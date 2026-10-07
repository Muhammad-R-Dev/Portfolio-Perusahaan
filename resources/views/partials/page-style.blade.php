{{-- Menyisipkan CSS warna kustom dari Pengaturan Halaman. Pemakaian: @include('partials.page-style', ['ps' => $ps]) --}}
@php $pageSettingCss = isset($ps) ? $ps->css() : ''; @endphp
@if($pageSettingCss !== '')
    @push('styles')
    <style id="page-setting-style">{!! $pageSettingCss !!}</style>
    @endpush
@endif
