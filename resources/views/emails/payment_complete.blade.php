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
                    <td>Default pin:</td>
                    <td>{{$pin}}</td>
                </tr>
                <tr>
                    <td>Transaction date:</td>
                    <td>{{$date}}</td>
                </tr>
                <tr>
                    <td>Reg date:</td>
                    <td>{{$regDate}}</td>
                </tr>
                <tr>
                    <td>Last purchases:</td>
                    <td>
                        @foreach($lastPurchases as $lastPurchase)
                            <li>{{$lastPurchase->getCreatedAt()->format(DATE_ATOM)}} (${{$lastPurchase->getConvertedAmount()}} USD)</li>
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td>Ebay:</td>
                    <td>{{$ebayId}}</td>
                </tr>
                <tr>
                    <td>Number of pins:</td>
                    <td>{{$pinCount}}</td>
                </tr>

                <tr>
                    <td>Amount:</td>
                    <td>{{$amount}}</td>
                </tr>
                <tr>
                    <td>Quantity:</td>
                    <td>{{$quantity}}</td>
                </tr>
                <tr>
                    <td>Subscriber name:</td>
                    <td>{{$name}}</td>
                </tr>
                <tr>
                    <td>Subscriber email:</td>
                    <td>{{$email}}</td>
                </tr>
                <tr>
                    <td>Country / state:</td>
                    <td>{{$country}} / {{$state}}</td>
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
