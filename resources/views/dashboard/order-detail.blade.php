<div class="row">
    <div class="col-md-5">
        @if ($order->menu->pict && file_exists(public_path('assets/pictures/menu/' . $order->menu->pict)))
            <img src="{{ asset('assets/pictures/menu/'.$order->menu->pict) }}" class="img-responsive img-rounded" style="margin-bottom: 20px; border: 1px solid #e2e8f0; max-height: 220px; width: 100%; object-fit: cover;">
        @else
            <img src="{{ asset('assets/pictures/profile.jpg') }}" class="img-responsive img-rounded" style="margin-bottom: 20px; border: 1px solid #e2e8f0;">
        @endif

        {{-- Badge Meja / Tipe Pesanan --}}
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; margin-bottom: 15px;">
            <div style="font-size: 11px; text-transform: uppercase; color: #64748b; font-weight: 700;">Tipe Pemesanan:</div>
            <div style="font-size: 14px; font-weight: 800; margin-top: 4px;">
                @if ($order->table_no)
                    <span class="label" style="background-color: #22714e; font-size: 12px;">
                        <i class="fa fa-cutlery"></i> Makan di Tempat ({{ $order->table_no }})
                    </span>
                @elseif ($order->delivery == 1)
                    <span class="label label-warning" style="font-size: 12px;">
                        <i class="fa fa-truck"></i> Antar ke Alamat (Delivery)
                    </span>
                @else
                    <span class="label label-info" style="font-size: 12px;">
                        <i class="fa fa-shopping-bag"></i> Bawa Pulang (Takeaway)
                    </span>
                @endif
            </div>
            <div style="font-size: 12px; color: #475569; margin-top: 6px;">
                Akun: <strong>{{ $order->user_id ? 'Member Terdaftar' : 'Tamu Scan QR' }}</strong>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="row">
            <div class="col-md-4">
                <strong>Pelanggan</strong>
            </div>
            <div class="col-md-8">
                : {{ $order->customer_name ?: $order->user->name }}
            </div>
        </div>

        @if (!empty($order->customer_phone) && $order->customer_phone != '-')
            <div class="row" style="margin-top: 5px;">
                <div class="col-md-4">
                    <strong>WhatsApp / HP</strong>
                </div>
                <div class="col-md-8">
                    : <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->customer_phone) }}" target="_blank" class="text-success" style="font-weight: 700;">
                        <i class="fa fa-whatsapp"></i> {{ $order->customer_phone }}
                    </a>
                </div>
            </div>
        @endif

        <div class="row" style="margin-top: 5px;">
            <div class="col-md-4">
                <strong>Menu</strong>
            </div>
            <div class="col-md-8">
                : <strong>{{ $order->menu->name }}</strong>
            </div>
        </div>

        @if (!empty($order->addons))
            <div class="row" style="margin-top: 5px;">
                <div class="col-md-4">
                    <strong style="color: #2563eb;">Add-ons</strong>
                </div>
                <div class="col-md-8" style="color: #2563eb;">
                    : <i class="fa fa-plus-circle"></i> {{ $order->addons }}
                </div>
            </div>
        @endif

        <div class="row" style="margin-top: 5px;">
            <div class="col-md-4">
                <strong>Jumlah</strong>
            </div>
            <div class="col-md-8">
                : {{ $order->qty }} Porsi
            </div>
        </div>
        <hr style="margin: 10px 0;">
        <div class="row">
            <div class="col-md-4">
                <strong>Jadwal / Waktu</strong>
            </div>
            <div class="col-md-8">
                : {{ date('d M Y - H:i', strtotime($order->order_for)) }}
            </div>
        </div>
        <div class="row" style="margin-top: 5px;">
            <div class="col-md-4">
                <strong>Lokasi / Alamat</strong>
            </div>
            <div class="col-md-8">
                : {{ $order->to_addr ?: ($order->table_no ?: 'Makan di Tempat') }}
            </div>
        </div>
        <hr style="margin: 10px 0;">
        <div class="row">
            <div class="col-md-4">
                <strong style="font-size: 15px;">Total Tagihan</strong>
            </div>
            <div class="col-md-8">
                <strong style="font-size: 18px; color: #e67e22;">
                    : Rp. {{ number_format($order->total, 0, ',', '.') }},-
                </strong>
            </div>
        </div>
    </div>
</div>
