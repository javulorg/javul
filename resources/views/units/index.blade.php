@extends('layout.master')
@section('title', 'Units')
<?php $donationType = 'unit'; ?>
@section('site-name')
    <h1>Javul.org</h1>
    <div class="banner_desc d-md-block d-none">
        Open-source Society
    </div>
@endsection
@section('style')
@endsection
@section('navbar')

@endsection

@section('content')
    <div class="content_row">
        <div class="sidebar">
            @if (isset($homeCheck) && $homeCheck != true)
                @include('layout.v2.global-unit-overview')
                <?php
                $title = 'Activity Log';
                ?>
                @include('layout.v2.global-activity-log', ['title' => $title])

                @include('layout.v2.global-finances')

                @include('layout.v2.global-about-site')
            @else
                <?php
                $title = 'Global Activity Log';
                ?>
                @include('layout.v2.global-activity-log', ['title' => $title])
            @endif
        </div>
        <div class="main_content">
            <div class="content_block">
                <div class="table_block table_block_units">
                    <div class="table_block_head">
                        <div class="table_block_icon">
                            <i class="fa-brands fa-stack-overflow"></i>
                        </div>
                        ({{ $unitsTotal }})
                        <div class="arrow">
                            <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
                        </div>
                    </div>
                    {{-- <div class="table_block_body">
                        <table>
                            <thead>
                                <tr>
                                    <th class="title_col">{{ __('messages.unit_name') }}</th>
                                    <th class="last_reply_col">{{ __('messages.unit_category') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($allUnits) > 0)
                                    @foreach ($allUnits as $unit)
                                        <?php $category_ids = $unit->category_id;

                                        $category_names = \App\Models\UnitCategory::getName($category_ids);
                                        $category_ids = explode(',', $category_ids);
                                        $category_names = explode(',', $category_names);
                                        ?>
                                        <tr>
                                            <td class="title_col">
                                                <a href="{!! url('units/' . $unitIDHashID->encode($unit->id) . '/' . $unit->slug) !!}">
                                                    {{ $unit->name }}
                                                </a>
                                            </td>
                                            <td class="last_reply_col">
                                                @if (count($category_ids) > 0)
                                                    @foreach ($category_ids as $index => $category)
                                                        <a href="{!! url('units/category=' . strtolower($category_names[$index])) !!}">{{ $category_names[$index] }}</a>
                                                        @if (count($category_ids) > 1 && $index != count($category_ids) - 1)
                                                            <span>&#44;</span>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No record(s) found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div> --}}

                    <div class="table_block_body">
                        <table>
                            <thead>
                                <tr>
                                    <th class="title_col">{{ __('messages.unit_name') }}</th>
                                    <th class="last_reply_col">{{ __('messages.unit_category') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($pagination) > 0)
                                    @foreach ($pagination as $unit)
                                        @php
                                            $category_ids = explode(',', $unit->category_id);
                                            $category_names = explode(
                                                ',',
                                                \App\Models\UnitCategory::getName($unit->category_id),
                                            );
                                        @endphp
                                        <tr>
                                            <td class="title_col">
                                                <a
                                                    href="{{ url('units/' . $unitIDHashID->encode($unit->id) . '/' . $unit->slug) }}">
                                                    {{ $unit->name }}
                                                </a>
                                            </td>
                                            <td class="last_reply_col">
                                                @if (count($category_ids) > 0)
                                                    @foreach ($category_ids as $index => $category)
                                                        <a
                                                            href="{{ url('units/category=' . strtolower($category_names[$index])) }}">
                                                            {{ $category_names[$index] }}
                                                        </a>
                                                        @if ($index !== count($category_ids) - 1)
                                                            <span>, </span>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">No record(s) found.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- Mobile Table -->
                        <div class="mob_table d-sm-none d-block">
                            @if (count($pagination) > 0)
                                @foreach ($pagination as $unit)
                                    @php
                                        $category_ids = explode(',', $unit->category_id);
                                        $category_names = explode(
                                            ',',
                                            \App\Models\UnitCategory::getName($unit->category_id),
                                        );
                                    @endphp
                                    <div class="mob_table_section">
                                        <div class="mob_table_row">
                                            <div class="mob_table_ttl">{{ __('messages.unit_name') }}</div>
                                            <div class="mob_table_val">
                                                <a
                                                    href="{{ url('units/' . $unitIDHashID->encode($unit->id) . '/' . $unit->slug) }}">
                                                    {{ $unit->name }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="mob_table_row">
                                            <div class="mob_table_ttl">{{ __('messages.unit_category') }}</div>
                                            <div class="mob_table_val">
                                                @foreach ($category_ids as $index => $category)
                                                    <a
                                                        href="{{ url('units/category=' . strtolower($category_names[$index])) }}">
                                                        {{ $category_names[$index] }}
                                                    </a>
                                                    @if ($index !== count($category_ids) - 1)
                                                        <span>, </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="mob_table_section">
                                    <div class="mob_table_row">
                                        <div class="mob_table_val text-center">No record(s) found.</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>


                <div class="d-flex justify-content-between mt-2">
                    <div class="pagination-left">
                        {!! $pagination->links('layout.pagination') !!}
                    </div>
                </div>

                </div>


                <div class="content_block_bottom">
                    <a href="{{ url('units/create') }}">
                        <img src="{{ asset('v2/assets/img/circle-plus.svg') }}" alt=""> Add New
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#master-units-table-id').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                sorting: false,
                lengthChange: false,
                autoWidth: false,
                pageLength: 5,
                searching: false,
                order: false,
                "ajax": {
                    "url": '{{ url('api/units/index') }}'
                },
                "columns": [{
                        "data": "title",
                    },
                    {
                        "data": "unit_category",
                    },
                ],
            });

        });
    </script>
@endsection
