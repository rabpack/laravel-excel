<table class="table rtl text-center">
    <thead>
    <tr>
        <th>
            مشخصات یوزر های اولی تا اخری

        </th>
    </tr>
    <tr style="background: #1a202c">
        <td>#</td>
        <td>نام</td>
        <td>شغل</td>
        <td>تاریخ تولد</td>
        <td>نام شرکت</td>
        <td>تعداد کارمندان شرکت</td>
        <td>تاریخ تاسیس شرکت</td>
    </tr>
    </thead>
    <tbody>

    @foreach($users as $user)

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->family }}</td>
            <td>{{ $user->mobile }}</td>
            <td>{{ $user->birthDate}}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>{{ $user->created_at->format('Y-m-d') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
