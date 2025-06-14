<?php

namespace App\Models;

use App\LedgerEntryType;
use App\MaterialType;
use App\UuidGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialLedger extends Model
{
    use HasFactory, UuidGenerator;

    protected $fillable = [
        'entry_type',
        'material_type',
        'quantity',
        'labour_id',
        'reference_id',
        'reference_type',
        'date',
        'remarks'
    ];

    protected $casts = [
        'entry_type' => LedgerEntryType::class,
        'material_type' => MaterialType::class,
        'quantity' => 'decimal:2',
        'date' => 'date',
    ];

    public function labour()
    {
        return $this->belongsTo(Labour::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }


    public static function recordPurchase(Purchase $purchase): void
    {
        $material = match ((int) $purchase->purchase_type->value) {
            1 => MaterialType::GOLD,
            2 => MaterialType::DIAMOND,
            3 => MaterialType::COLOR_STONE,
        };

        self::create([
            'entry_type' => LedgerEntryType::PURCHASE,
            'material_type' => $material,
            'quantity' => $purchase->purchase_type === 1 ? $purchase->weight_in_gram : $purchase->carat,
            'labour_id' => null,
            'reference_id' => $purchase->id,
            'reference_type' => 'App\Models\Purchase',
            'date' => $purchase->purchase_date,
            'remarks' => 'Purchase entry',
        ]);
    }

    public static function recordSale(InvoiceItem $invoiceItem): void
    {
        self::create([
            'entry_type' => LedgerEntryType::SALE,
            'material_type' => MaterialType::PRODUCT,
            'quantity' => $invoiceItem->quantity,
            'labour_id' => null,
            'reference_id' => $invoiceItem->invoice->id,
            'reference_type' => 'App\Models\Invoice',
            'date' => $invoiceItem->invoice->purchase_date,
            'remarks' => 'Sale entry',
        ]);
    }

    public static function recordApprovalOut(ApprovalOut $approval): void
    {
        $material = match ((int) $approval->approval_type->value) {
            1 => MaterialType::GOLD,
            2 => MaterialType::DIAMOND,
            3 => MaterialType::COLOR_STONE,
        };
        $remark = match ((int) $approval->approval_type->value) {
            1 => 'Approval Out - Gold',
            2 => 'Approval Out - Diamond',
            3 => 'Approval Out - Color Stone',
            default => 'Approval Out'
        };

        self::create([
            'entry_type' => LedgerEntryType::APPROVAL_OUT,
            'material_type' => $material,
            'quantity' => $approval->qty,
            'labour_id' => $approval->labour_id,
            'reference_id' => $approval->id,
            'reference_type' => 'App\Models\ApprovalOut',
            'date' => $approval->date,
            'remarks' => $remark,
        ]);
    }

    public static function recordProductIn(Product $product): void
    {
        if ($product->gold_qty > 0) {
            self::create([
                'entry_type' => LedgerEntryType::APPROVAL_IN,
                'material_type' => MaterialType::GOLD,
                'quantity' => $product->gold_qty,
                'labour_id' => $product->gold_labour_id,
                'reference_id' => $product->id,
                'reference_type' => 'App\Models\Product',
                'date' => $product->created_at->format('Y-m-d'),
                'remarks' => 'Product In - Gold',

            ]);
        }

        if ($product->diamond_qty > 0) {
            self::create([
                'entry_type' => LedgerEntryType::APPROVAL_IN,
                'material_type' => MaterialType::DIAMOND,
                'quantity' => $product->diamond_qty,
                'labour_id' => $product->diamond_labour_id,
                'reference_id' => $product->id,
                'reference_type' => 'App\Models\Product',
                'date' => $product->created_at->format('Y-m-d'),
                'remarks' => 'Product In - Diamond',

            ]);
        }

        if ($product->color_stone_qty > 0) {
            self::create([
                'entry_type' => LedgerEntryType::APPROVAL_IN,
                'material_type' => MaterialType::COLOR_STONE,
                'quantity' => $product->color_stone_qty,
                'labour_id' => $product->color_stone_labour_id,
                'reference_id' => $product->id,
                'reference_type' => 'App\Models\Product',
                'date' => $product->created_at->format('Y-m-d'),
                'remarks' => 'Product In - Color Stone',

            ]);
        }
    }
}
