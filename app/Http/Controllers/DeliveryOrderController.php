<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

use App\Models\DeliveryOrder;
use App\Models\DetailDelivery;
use App\Models\Distribusi;
use App\Models\totalStock;
use App\Models\DetailDistribusi;


class DeliveryOrderController extends Controller
{
    public function index()
    {
        $delivery = DeliveryOrder::all();
        return view('admin.DeliveryOrder.index', compact('delivery'));
    }


    public function store(Request $request)
    {
        $namaSopir = $request->input('namaSopir');
        $platNomor = $request->input('platNomor');
        $orders = $request->input('orders');

        $timestamp = time(); // Waktu saat ini dalam detik
        $randomValue = mt_rand(1000, 9999); // Nilai acak antara 1000 dan 9999

        // Gabungkan elemen-elemen tersebut untuk membuat kode transaksi
        $kode_delivery = 'DO' . date('mdH', $timestamp) . $randomValue;

        $delivery = new DeliveryOrder;
        $delivery->kode_delivery_orders = $kode_delivery;
        $delivery->nama_sopir = $namaSopir;
        $delivery->plat_no = $platNomor;
        $delivery->tanggal_kirim = now()->toDateString();
        $delivery->jumlah_deliveryOrder = null;
        $delivery->save();

        $totalberat = 0;
        foreach ($orders as $order) {
            $DetailDelivery = new DetailDelivery();
            $DetailDelivery->id_delivery = $delivery->id_delivery;
            $DetailDelivery->id_distribusi = $order;

            $distribusi = Distribusi::find($order);
            if ($distribusi) {
                $totalberat += $distribusi->jumlah_distribusi;
                $distribusi->update([
                    'status' => "Dikirim",
                ]);
            }
            $DetailDelivery->save();
        }

        $delivery->jumlah_deliveryOrder = $totalberat;
        $delivery->save();
    }

    public function show($id)
    {
        $delivery = DeliveryOrder::with('detailDelivery.distribusi')->find($id);
        $detailDeliveries = DetailDelivery::where('id_delivery', $id)->get();
        $merk = totalStock::all();

        return view('admin.DeliveryOrder.show', compact('delivery' ,'detailDeliveries', 'merk'));
    }

    public function showDO($id)
    {
        $delivery = DeliveryOrder::with('detailDelivery.distribusi')->find($id);
        $detailDeliveries = DetailDelivery::where('id_delivery', $id)->get();
        $detailDistribusi = [];

        if (!$detailDeliveries->isEmpty()) {
            foreach( $detailDeliveries as $del){
                $id_distribusi = $del->id_distribusi;
                $detailDistribusi[] = DetailDistribusi::where('id_distribusi', $id_distribusi)->get();
            }
        }

        $merk = totalStock::where('status','Baik')->get();
        // dd($delivery, $detailDeliveries, $detailDistribusi);

        return view('admin.DeliveryOrder.printDO', compact('delivery', 'detailDeliveries', 'merk', 'detailDistribusi'));
    }


    public function destroy($id)
    {
        $delivery = DeliveryOrder::find($id);
        $dataDetails = DetailDelivery::where('id_delivery', $delivery->id_delivery)->get();

        foreach ($dataDetails as $detail) {
            $detail->delete();
        }

        $delivery->delete();

        return redirect()->route('admin.DeliveryOrder.index')->with('success', 'Riwayat Delivery Order telah dihapus.');
    }


    public function cetak($id)
    {
        $delivery = DeliveryOrder::with('detailDelivery.distribusi')->find($id);
        $detailDeliveries = DetailDelivery::where('id_delivery', $id)->get();
        $detailDistribusi = [];

        if (!$detailDeliveries->isEmpty()) {
            foreach( $detailDeliveries as $del){
                $id_distribusi = $del->id_distribusi;
                $detailDistribusi[] = DetailDistribusi::where('id_distribusi', $id_distribusi)->get();
            }
        }

        $merk = totalStock::where('status','Baik')->get();

        $view = view('admin.DeliveryOrder.printDO', compact('delivery', 'detailDeliveries', 'merk', 'detailDistribusi'));

        $pdf = PDF::loadHtml($view);

        // (Optional) Set the paper size and orientation
        $pdf->setPaper('A4', 'landscape');

        // (Optional) Add header and footer
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isFontSubsettingEnabled' => true,
        ]);

        // (Optional) Set additional configuration options
        $pdf->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);

        return $pdf->download('Delivery-' .$delivery->kode_delivery_orders. '.pdf');
    }
}
