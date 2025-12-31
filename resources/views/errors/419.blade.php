@extends('layouts.master-without-nav')

@section('title')
    @lang('translation.Error_404')
@endsection

    @section('content')

        <script type="text/javascript">
            //reload on current page
            window.location = '';

        </script>

    @endsection
