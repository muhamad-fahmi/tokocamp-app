@component('mail::message')
# Your Orders
<?php
    $ccart = [];
    $pcart = [];
?>
Hi {{ $user }}, Thanks for your order in Tokocamp.

Pesanan Anda :

@component('mail::table')
| QTY    | ITEMS                                  | TOTAL    |
|:------:|:-------------------------------------- | --------:|
@foreach ($packages as $package)
| {{ $package->total }} | {{ $package->package->name }} | {{ number_format((int)$package->package->price * $package->total,0,',','.') }} |
<?php
$pcart[] = $package->package->price * $package->total;
?>
@endforeach
@foreach ($campinggears as $campinggear)
| {{ $campinggear->total }} | {{ $campinggear->campinggear->name }} | {{ number_format((int)$campinggear->campinggear->price * $campinggear->total,0,',','.') }} |
<?php
$ccart[] = $campinggear->campinggear->price * $campinggear->total;
?>
@endforeach
@endcomponent

Untuk melanjutkan pesanan anda pada tanggal {{ Carbon\Carbon::parse($packages[0]->bookdate)->format('d-m-Y')}}, silahkan lakukan pembayaran untuk pesanan anda sebesar :

@component('mail::panel')
{{ "Rp " . number_format((int)array_sum($pcart) + array_sum($ccart),0,',','.') }}
@endcomponent

Silahkan melakukan pembayaran ke rekening atau nomor dibawah :

@component('mail::panel')
{{ env('NOREK') }} | BCA a/n Muhamad Rizal

{{ env('NOOVO') }} | OVO a/n Muhamad Rizal

{{ env('NODANA') }} | Dana a/n Muhamad Rizal

{{ env('NOLINK') }} | Link Aja a/n Muhamad Rizal
@endcomponent

Setelah melakukan pembayaran silahkan konfirmasi ke nomor WhatsApp {{ env('NODANA') }}

@component('mail::button', ['url' => 'https://wa.me/+'.env('NOWA').'?text='.urlencode('Hallo Admin, Saya ingin konfirmasi pembayaran untuk pesanan dengan email '.auth()->user()->email)])
Konfirmasi Pembayaran
@endcomponent

Best Regards,<br>
{{ config('app.name') }}

@component('mail::panel')
Be careful of any fraud on behalf of Tokocamp in any form. We only have 2 official emails, namely adm.tokocamp(at)gmail(dot)com and tokocamp.indonesia(at)gmail(dot)com
------------------
Hati-hati terhadap segala penipuan yang mengatasnamakan tokocamp dalam bentuk apapun. kami hanya memiliki 2 email official yaitu adm.tokocamp(at)gmail(dot)com dan tokocamp.indonesia(at)gmail(dot)com
@endcomponent
@endcomponent
