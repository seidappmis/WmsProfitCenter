<!DOCTYPE html>
<html>
<head>
  <title>Hi</title>
</head>
<body>
  <h1>PDF Berita Acara Tes</h1>
  <table class="table-data">
    <thead>
      <tr>
        <th>No</th>
        <th>No Do</th>
        <th>Model/Item No.</th>
        <th>No Seri</th>
        <th>Qty</th>
        <th>Jenis Kerusakan</th>
        <th>Keterangan</th>
      </tr>
     </thead>
     <tbody>
      @php
      $no=1;
      @endphp
      @foreach ($data as $item)
       <tr>
         <td>{{ $no++ }}</td>
         <td>{{ $item->do_no }}</td>
         <td>{{ $item->model_name }}</td>
         <td>{{ $item->serial_number }}</td>
         <td>{{ $item->qty }}</td>
         <td>{{ $item->description }}</td>
         <td>{{ $item->keterangan }}</td>
       </tr>
      @endforeach
     </tbody>
   </table>
</body>
</html>