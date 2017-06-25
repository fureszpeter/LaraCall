@extends('beautymail::templates.minty')

@section('content')

    @include('beautymail::templates.minty.contentStart')
    <tr>
        <td class="title">
            Welcome Peter!
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="paragraph">
            This is a paragraph text
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td class="title">
            {{$subject}}
        </td>
    </tr>
    <tr>
        <td width="100%" height="10"></td>
    </tr>
    <tr>
        <td class="paragraph">

            <table>
                <tr>
                    <td>Connection</td>
                    <td>
                        {{$connection}}
                    </td>
                </tr>
                <tr>
                    <td>Job:</td>
                    <td>{{$job}}</td>
                </tr>
                <tr>
                    <td>Exception:</td>
                    <td>{{$exception}}</td>
                </tr>
                <tr>
                    <td>Trace:</td>
                    <td>{{$trace}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    <tr>
        <td>
            @include('beautymail::templates.minty.button', ['text' => 'Open user', 'link' => '#'])
        </td>
    </tr>
    <tr>
        <td width="100%" height="25"></td>
    </tr>
    @include('beautymail::templates.minty.contentEnd')

@stop
