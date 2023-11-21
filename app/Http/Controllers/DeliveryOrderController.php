<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DeliveryOrder;
use App\Models\DetailDelivery;
use App\Models\Distribusi;
use App\Models\totalStock;

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
                    'status' => "Terkirim",
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
    $detailDeliveries = $delivery->detailDelivery;
    $merk = totalStock::all();

    return view('admin.DeliveryOrder.show', compact('delivery' ,'detailDeliveries', 'merk'));
}

    public function destroy($id)
    {
        //
    }
}
