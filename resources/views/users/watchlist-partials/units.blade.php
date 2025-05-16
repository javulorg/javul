<!-- Include these in your <head> or before </body> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<div class="content_block">
    <div class="table_block table_block_units">
        <div class="table_block_head" onclick="toggleUnitsTable()" style="cursor: pointer;">
            <div class="table_block_icon">
                <i class="fa-brands fa-stack-overflow"></i>
            </div>
            Units
            <div class="arrow">
                <img src="{{ asset('v2/assets/img/bottom.svg') }}" alt="">
            </div>
        </div>

        <div class="table_block_body" id="unitsTableBody">
            <table id="watchlist-units-table-id" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th class="title_col">Unit Name</th>
                        <th class="title_col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($watchedUnittotal as $watchedUnit)
                        <tr>
                            <td>{{ $watchedUnit->name }}</td>
                            {{-- <td>{{ $watchedUnit->description }}</td> --}}
                            <td>{{ strip_tags($watchedUnit->description) }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        $('#watchlist-units-table-id').DataTable({
            dom: 't',
            paging: false,
        });
    });
</script>
