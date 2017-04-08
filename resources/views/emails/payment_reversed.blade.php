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

            Pins:<br>
            <ul>
            @foreach($pins as $pin)
                <li>{{$pin}}</li>
            @endforeach
            </ul>
            <table>
                <tr>
                    <td>Subscriber name:</td>
                    <td>{{$name}}</td>
                </tr>
                <tr>
                    <td>Number of pins:</td>
                    <td>{{$pinCount}}</td>
                </tr>
                <tr>
                    <td>Balance:</td>
                    <td>{{$credit}}</td>
                </tr>
                <tr>
                    <td>Last used:</td>
                    <td>{{$lastUsed}}</td>
                </tr>
                <tr>
                    <td>Ebay user reg. date:</td>
                    <td>{{$ebayRegistrationDate}}</td>
                </tr>
                <tr>
                    <td>Subscriber email:</td>
                    <td>{{$email}}</td>
                </tr>
                <tr>
                    <td>Country / state:</td>
                    <td>{{$country}} / {{$state}}</td>
                </tr>
                <tr>
                    <td>Ebay:</td>
                    <td>{{$ebayUsername}}</td>
                </tr>
                <tr>
                    <td>Amount:</td>
                    <td>{{$amount}}</td>
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
