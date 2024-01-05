<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $categoryId = request('categoryId');

        // $result = Category::where('id', request('categoryId'))->value('name');
        // dd($result);
        return view(
            'product.index',
            [
                'products' => Product::with('category')->filter(request(['search', 'categoryId']))->paginate(10),
                'categories' => Category::all(),
                'categoryName' => Category::where('id', request('categoryId'))->value('name'),
                'active' => 'product'
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request);
        // return $request->file('image');
        $validatedData = $request->validate(Product::$rules);

        // Calculate sell price based on buy price
        $validatedData['sellPrice'] = floatval(str_replace(',', '', $validatedData['sellPrice']));
        $validatedData['buyPrice'] = floatval(str_replace(',', '', $validatedData['buyPrice']));

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }

        // return $validatedData;
        Product::create($validatedData);

        return redirect('/product');
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate(Product::$updateRules);

        $validatedData['sellPrice'] = floatval(str_replace(',', '', $validatedData['sellPrice']));
        $validatedData['buyPrice'] = floatval(str_replace(',', '', $validatedData['buyPrice']));

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('images', $imageName, 'public');
            $validatedData['image'] = $imageName;
        }

        Product::where('id', request('id'))->update($validatedData);

        return redirect('/product')->with('success', 'Produk telah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $result = Product::where('id', request('productId'))->value('id');
        // dd($result);
        Product::destroy($result);

        return redirect('/product')->with('success', 'Sukses menghapus produk');
    }

    public function export()
    {
        // Fetch products with their associated category details
        $products = Product::with('category')->get();

        // Prepare data for Excel export
        $exportData = [];
        $exportData[] = ['No', 'Nama Produk', 'Kategori Produk', 'Harga Barang', 'Harga Jual', 'Stok'];


        // $rowCount = 1;
        // foreach ($products as $product) {
        //     $exportData[] = [
        //         'No' => $rowCount++,
        //         'Nama Produk' => $product->name,
        //         'Kategori Produk' => $product->category->name,
        //         'Harga Barang' => $product->buyPrice,
        //         'Harga Jual' => $product->sellPrice,
        //         'Stok' => $product->stock,
        //     ];
        // }

        // $excelFileName = 'products_data_' . date('Y-m-d') . '.xls';
        // $excelFilePath = storage_path('exports/' . $excelFileName);

        // $file = fopen($excelFilePath, 'w');
        // foreach ($exportData as $row) {
        //     fputs($file, $row, "\t");
        // }
        // fclose($file);

        // // Return Excel file as a download response
        // return response()->download($excelFilePath, $excelFileName)->deleteFileAfterSend(true);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headerRow = 3;
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'cc3300'], // Replace with your desired color code
            ],
        ];

        // Apply style to header row
        $sheet->getStyle('A' . $headerRow . ':F' . $headerRow)->applyFromArray($headerStyle);
        $sheet->getStyle('A')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


        // Set row width
        $sheet->getColumnDimension('A')->setWidth(5); // Adjust column A width as needed
        $sheet->getColumnDimension('B')->setWidth(35); // Adjust column B width as needed
        $sheet->getColumnDimension('C')->setWidth(20); // Adjust column B width as needed
        $sheet->getColumnDimension('D')->setWidth(12); // Adjust column B width as needed
        $sheet->getColumnDimension('E')->setWidth(12); // Adjust column B width as needed
        $sheet->getColumnDimension('F')->setWidth(10); // Adjust column B width as needed

        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Nama Produk');
        $sheet->setCellValue('C3', 'Kategori Produk');
        $sheet->setCellValue('D3', 'Harga Barang');
        $sheet->setCellValue('E3', 'Harga Jual');
        $sheet->setCellValue('F3', 'Stok');

        $i = 4;
        $no = 1;
        foreach ($products as $product) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, $product->name);
            $sheet->setCellValue('C' . $i, $product->category->name);
            $sheet->setCellValue('D' . $i, number_format($product->buyPrice, 0, '.', ','));
            $sheet->setCellValue('E' . $i, number_format($product->sellPrice, 0, '.', ','));
            $sheet->setCellValue('F' . $i, $product->stock);
            $row = 'A' . $i . ':F' . $i;
            $sheet->getStyle($row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ]);
            $i++;
        }

        $titleCell = 'A1:F1'; // Define the cell range for the title
        $sheet->mergeCells($titleCell); // Merge cells for the title
        $sheet->setCellValue('A1', 'DATA PRODUK'); // Set the title text
        $sheet->getStyle($titleCell)->getFont()->setBold(true)->setSize(20); // Set the title font to bold
        $sheet->getStyle($titleCell)->getAlignment()->setHorizontal('center'); // Center align the title

        $writer = new Xlsx($spreadsheet);
        $excelFileName = 'data_product.xlsx';
        $excelFilePath = storage_path('exports/' . $excelFileName);

        dd($excelFilePath);
        $writer->save($excelFilePath);

        return response()->download($excelFilePath, $excelFileName)->deleteFileAfterSend(true);
    }
}
