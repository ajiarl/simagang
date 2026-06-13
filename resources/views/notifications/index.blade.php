@extends('layouts.app')

@section('title', 'Semua Notifikasi')
@section('page-title', 'Pusat Notifikasi')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="padding: 16px 20px; border-bottom: 1px solid #c2c6d3; display: flex; justify-content: space-between; align-items: center;">
        <h3 class="text-headline-sm" style="color: #191c20;">Semua Notifikasi</h3>
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.markAllAsRead') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-secondary" style="padding: 6px 12px; font-size: 13px;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">done_all</span>
                    Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    <div style="display: flex; flex-direction: column;">
        @forelse($notifications as $notification)
            <div style="padding: 16px 20px; border-bottom: 1px solid #e2e2e9; display: flex; gap: 16px; align-items: flex-start; {{ is_null($notification->read_at) ? 'background: #f8fafc;' : '' }}">
                <div style="background: {{ is_null($notification->read_at) ? '#dcfce7' : '#f0f4f8' }}; padding: 12px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="color: {{ $notification->data['color'] ?? '#0058be' }};">{{ $notification->data['icon'] ?? 'notifications' }}</span>
                </div>
                
                <div style="flex: 1;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                        <h4 class="text-body-md" style="font-weight: 600; color: #191c20; margin: 0;">{{ $notification->data['title'] ?? 'Notifikasi' }}</h4>
                        <span class="text-label-sm" style="color: #737782;">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-body-sm" style="color: #424751; margin: 0 0 8px 0; line-height: 1.5;">{{ $notification->data['message'] ?? '' }}</p>
                    
                    @if(isset($notification->data['url']))
                        <a href="{{ $notification->data['url'] }}" class="text-label-sm" style="color: #0058be; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 4px;">
                            Lihat Detail <span class="material-symbols-outlined" style="font-size: 14px;">arrow_forward</span>
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div style="padding: 40px 20px; text-align: center;">
                <span class="material-symbols-outlined" style="font-size: 48px; color: #737782; margin-bottom: 16px; opacity: 0.5;">notifications_off</span>
                <p class="text-body-md" style="color: #424751;">Belum ada notifikasi.</p>
            </div>
        @endforelse
    </div>
    
    @if($notifications->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #c2c6d3;">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
@endsection
