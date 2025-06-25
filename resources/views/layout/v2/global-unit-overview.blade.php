<div class="sidebar_block">
    <div class="sidebar_block_ttl">
        Unit Overview
        <div class="arrow">
            <img src="{{ asset('v2/assets/img/bottom_y.svg') }}" alt="">
        </div>
    </div>
    <div class="sidebar_block_content">
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Type:
            </div>
            <div class="sidebar_block_right">
                @if (isset($unitObj) && $unitObj->unit_type == 0)
                    Product
                @elseif(isset($unitObj) && $unitObj->unit_type == 1)
                    Service
                @else
                    People’s Government
                @endif
            </div>
        </div>
        {{-- @dd($unitObj) --}}
        @if (isset($unitObj) && ($unitObj->unit_type == 0 || $unitObj->unit_type == 1))
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Product Name:
                </div>
                <div class="sidebar_block_right">
                    {{ $unitObj->product_name }}
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Service Name:
                </div>
                <div class="sidebar_block_right">
                    {{ $unitObj->service_name }}
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Business Model:
                </div>
                <div class="sidebar_block_right">
                    @if ($unitObj->business_model == 0)
                        Community-owned
                    @else
                        Corporate
                    @endif
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Operational Grade:
                </div>
                <div class="sidebar_block_right">
                    {{ $unitObj->operational_grade }} <img src="{{ asset('v2/assets/img/question.svg') }}"
                        alt="" class="question">
                </div>
            </div>

            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Company :
                </div>
                <div class="sidebar_block_right">
                    {{ $unitObj->company }}
                </div>
            </div>
        @elseif(isset($unitObj) && $unitObj->unit_type == 2)
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Scope :
                </div>
                <div class="sidebar_block_right">
                    @if ($unitObj->scope == 0)
                        City
                    @elseif($unitObj->scope == 1)
                        County
                    @elseif($unitObj->scope == 2)
                        State
                    @elseif($unitObj->scope == 3)
                        National
                    @elseif($unitObj->scope == 4)
                        International
                    @else
                    @endif

                </div>
            </div>
        @else
            <div class="sidebar_block_row">
                <div class="sidebar_block_left">
                    Scope :
                </div>
                <div class="sidebar_block_right">

                </div>
            </div>
        @endif





        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Issue Resolution:
            </div>
            <div class="sidebar_block_right">
                <div class="blue_progress"></div>
                {{-- dd($totalIssueResolutions) --}}
                {{ $totalIssueResolutions }}
            </div>
        </div>
        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Location:
            </div>
            <div class="sidebar_block_right">
                Worldwide
            </div>
        </div>

        <div class="sidebar_block_row">
            <div class="sidebar_block_left">
                Funded:
            </div>
            <div class="sidebar_block_right">
                <div class="green_progress"></div> 105%
            </div>
        </div>
        @if (isset($unitObj))
            <div class="sidebar_block_content_bottom">
                {{-- @dd($unitObj) --}}

                @php
            $isWatched = auth()->check() && \App\Models\Watchlist::where('user_id', auth()->id())
            ->where('unit_id', $unitObj->id)
            ->exists();
            @endphp

            <a href="javascript:void(0);" class="edit_icon watchlist-link"
                data-user-id="{{ auth()->id() ?? '' }}"
                data-unit-id="{{ $unitObj->id }}"
                data-auth="{{ auth()->check() ? 'yes' : 'no' }}"
                data-url="{{ route('watchlistU.store', ['unitId' => $unitObj->id]) }}"
                id="eye-link-{{ $unitObj->id }}"
                style="{{ $isWatched ? 'display: none;' : '' }}">
                <img src="{{ asset('v2/assets/img/eye.svg') }}" style="height: 20px; width: 20px;" alt="Watch">
            </a>

            <a href="javascript:void(0);" class="edit_icon unwatchlist-link"
                data-unit-id="{{ $unitObj->id }}"
                data-auth="{{ auth()->check() ? 'yes' : 'no' }}"
                data-url="{{ route('watchlistU.remove', ['unitId' => $unitObj->id]) }}"
                id="eye-off-link-{{ $unitObj->id }}"
                style="{{ $isWatched ? '' : 'display: none;' }}">
                <img src="{{ asset('v2/assets/img/eye-slash.svg') }}" style="height: 20px; width: 20px;" alt="Unwatch">
            </a>


                <div class="separator"></div>
                <a href="{!! route('unit_revison', [$unitIDHashID->encode($unitObj->id)]) !!}"><i class="fa fa-history"></i></a>
                <div class="separator"></div>
                <a href="{!! url('units/' . $unitIDHashID->encode($unitObj->id) . '/edit') !!}"><i class="fa fa-edit"></i></a>
                <div class="separator"></div>
                <a class="add_to_my_watchlist" data-type="unit" data-id="{{ $unitIDHashID->encode($unitObj->id) }}"
                    data-redirect="{{ url()->current() }}"><i class="fa fa-list"></i></a>

                @auth
                    @if (Auth::user()->role == 2)
                        <div class="separator"></div>
                        <a href="{!! url('admin/settings/' . $unitIDHashID->encode($unitObj->id)) !!}"><i class="fa fa-cogs"></i></a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</div>


<!-- Include SweetAlert2 (CDN link if not already included) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = '{{ csrf_token() }}';
        const loginUrl = "{{ route('login') }}";

        document.body.addEventListener('click', function(e) {
            const watchBtn = e.target.closest('.watchlist-link');
            const unwatchBtn = e.target.closest('.unwatchlist-link');

            // Add to Watchlist
            if (watchBtn) {
                const isAuth = watchBtn.dataset.auth;
                if (isAuth === 'no') {
                    return window.location.href = loginUrl;
                }

                const unitId = watchBtn.dataset.unitId;
                const url = watchBtn.dataset.url;

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({})
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.message === 'Added to watchlist!') {
                            document.getElementById('eye-link-' + unitId).style.display = 'none';
                            document.getElementById('eye-off-link-' + unitId).style.display = 'inline-block';

                            Swal.fire({
                                title: 'Success!',
                                text: 'Unit added to your watchlist.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Info',
                                text: data.message || 'Already in watchlist.',
                                icon: 'info',
                                confirmButtonText: 'OK'
                            });
                        }
                    })
                    .catch(() => {
                        Swal.fire({
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }

            // Remove from Watchlist
            if (unwatchBtn) {
                const isAuth = unwatchBtn.dataset.auth;
                if (isAuth === 'no') {
                    return window.location.href = loginUrl;
                }

                const unitId = unwatchBtn.dataset.unitId;
                const url = unwatchBtn.dataset.url;

                fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('eye-link-' + unitId).style.display = 'inline-block';
                        document.getElementById('eye-off-link-' + unitId).style.display = 'none';

                        Swal.fire({
                            title: 'Removed!',
                            text: 'Unit removed from your watchlist.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    })
                    .catch(() => {
                        Swal.fire({
                            title: 'Error',
                            text: 'Could not remove from watchlist.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
            }
        });
    });
</script>
