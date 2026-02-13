<?php

namespace App\Services;

use App\Enums\StockMovementType;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use RuntimeException;

/**
 * StockService — Production Ready (Inventory Internal)
 * --------------------------------------------------
 * RULES:
 * - Semua perubahan stok HARUS lewat service ini
 * - Tidak boleh update tabel stocks secara langsung
 * - Selalu create stock_movements (audit trail)
 * - Pakai DB transaction + row locking
 */
class StockService
{
    /**
     * Tambah stok (Barang Masuk)
     */
    public function addStock(
        int $productId,
        int $warehouseId,
        int $qty,
        string $referenceType,
        int $referenceId,
        ?string $notes = null,
        ?int $userId = null
    ): void {
        if ($qty <= 0) {
            throw new RuntimeException('Qty harus lebih dari 0');
        }

        DB::transaction(function () use (
            $productId,
            $warehouseId,
            $qty,
            $referenceType,
            $referenceId,
            $notes,
            $userId
        ) {
            $stock = Stock::where('product_id', $productId)
                ->where('warehouse_id', $warehouseId)
                ->lockForUpdate()
                ->first();

            if (! $stock) {
                $stock = Stock::create([
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId,
                    'qty' => 0,
                ]);
            }

            $stock->increment('qty', $qty);

            $this->logMovement(
                $productId,
                $warehouseId,
                StockMovementType::IN->value,
                $qty,
                $referenceType,
                $referenceId,
                $notes,
                $userId
            );
        });
    }

    /**
     * Kurangi stok (Barang Keluar)
     */
    public function removeStock(
        int $productId,
        int $warehouseId,
        int $qty,
        string $referenceType,
        int $referenceId,
        ?string $notes = null,
        ?int $userId = null
    ): void {
        if ($qty <= 0) {
            throw new RuntimeException('Qty harus lebih dari 0');
        }

        DB::transaction(function () use (
            $productId,
            $warehouseId,
            $qty,
            $referenceType,
            $referenceId,
            $notes,
            $userId
        ) {
            $stock = Stock::where('product_id', $productId)
                ->where('warehouse_id', $warehouseId)
                ->lockForUpdate()
                ->first();

            if (! $stock) {
                throw new RuntimeException('Stok tidak ditemukan');
            }

            if ($stock->qty < $qty) {
                throw new RuntimeException('Stok tidak cukup');
            }

            $stock->decrement('qty', $qty);

            $this->logMovement(
                $productId,
                $warehouseId,
                StockMovementType::OUT->value,
                $qty,
                $referenceType,
                $referenceId,
                $notes,
                $userId
            );
        });
    }

    /**
     * Penyesuaian stok (Stock Opname)
     */
    public function adjustStock(
        int $productId,
        int $warehouseId,
        int $newQty,
        string $referenceType,
        int $referenceId,
        ?string $notes = null,
        ?int $userId = null
    ): void {
        if ($newQty < 0) {
            throw new RuntimeException('Qty tidak boleh minus');
        }

        DB::transaction(function () use (
            $productId,
            $warehouseId,
            $newQty,
            $referenceType,
            $referenceId,
            $notes,
            $userId
        ) {
            $stock = Stock::where('product_id', $productId)
                ->where('warehouse_id', $warehouseId)
                ->lockForUpdate()
                ->first();

            if (! $stock) {
                $stock = Stock::create([
                    'product_id' => $productId,
                    'warehouse_id' => $warehouseId,
                    'qty' => 0,
                ]);
            }

            $diff = $newQty - $stock->qty;

            if ($diff === 0) {
                return;
            }

            $stock->update(['qty' => $newQty]);

            $this->logMovement(
                $productId,
                $warehouseId,
                StockMovementType::ADJUST->value,
                abs($diff),
                $referenceType,
                $referenceId,
                $notes,
                $userId
            );
        });
    }

    /**
     * Transfer antar gudang
     */
    public function transferStock(
        int $productId,
        int $fromWarehouseId,
        int $toWarehouseId,
        int $qty,
        string $referenceType,
        int $referenceId,
        ?string $notes = null,
        ?int $userId = null
    ): void {
        DB::transaction(function () use (
            $productId,
            $fromWarehouseId,
            $toWarehouseId,
            $qty,
            $referenceType,
            $referenceId,
            $notes,
            $userId
        ) {
            $this->removeStock(
                $productId,
                $fromWarehouseId,
                $qty,
                $referenceType,
                $referenceId,
                'TRANSFER OUT — ' . $notes,
                $userId
            );

            $this->addStock(
                $productId,
                $toWarehouseId,
                $qty,
                $referenceType,
                $referenceId,
                'TRANSFER IN — ' . $notes,
                $userId
            );
        });
    }

    /**
     * Ambil stok saat ini
     */
    public function getStock(int $productId, int $warehouseId): int
    {
        return (int) Stock::where('product_id', $productId)
            ->where('warehouse_id', $warehouseId)
            ->value('qty') ?? 0;
    }

    /**
     * Internal — catat movement
     */
    protected function logMovement(
        int $productId,
        int $warehouseId,
        string $type,
        int $qty,
        string $referenceType,
        int $referenceId,
        ?string $notes,
        ?int $userId
    ): void {
        StockMovement::create([
            'product_id' => $productId,
            'warehouse_id' => $warehouseId,
            'type' => $type,
            'qty' => $qty,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'notes' => $notes,
            'user_id' => $userId ?? Auth::id(),

        ]);
    }
}
