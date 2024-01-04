<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport
{
  public function collection()
  {
    return Product::with('category')->get(['productName', 'category_id', 'sellPrice', 'buyPrice', 'stock']);
  }

  public function headings(): array
  {
    return [
      'Product Name',
      'Category Name',
      'Sell Price',
      'Buy Price',
      'Stock',
    ];
  }
}
