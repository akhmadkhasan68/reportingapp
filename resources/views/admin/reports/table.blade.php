@if($reports->count() > 0)
    @php $no = 1; @endphp
    @foreach($reports as $report)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $report->name }}</td>
            <td>{{ $report->description }}</td>
            <td>{{ $report->votes_count }}</td>
            <td>@if($report->status == 0) <span class="badge badge-warning">Belum Diriview</span> @elseif($report->status == 1) <span class="badge badge-success">Diterima</span> @else <span class="badge badge-danger">Ditolak</span> @endif</td>
            <td>
                <a href="{{ route('reports.show', $report->id) }}" class="btn btn-info btn-sm">Detail</a>
                <button class="btn btn-danger btn-sm" onclick="deleteData(`{{ route('reports.destroy', $report->id) }}`)">Hapus</button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="6">
            <center>Data Kosong!</center>
        </td>
    </tr>
@endif