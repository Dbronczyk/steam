@extends('layout')

@section('title', 'Stwórz nową ofertę')

@section('css')
    <link href="{{ URL::asset('ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('easy-autocomplete/easy-autocomplete.css') }}" rel="stylesheet">
@stop


@section('content')


    <h2>Stwórz nową ofertę</h2>

    {!! Form::open(array('url' => 'sale')) !!}
    <div class="row" id="1">


        <div class="col-md-4">
            <input data-autocomplete class="form-control show" id="basics1" placeholder="Nazwa gry" required/>
            <input class="hiddenn" type="hidden"/>
        </div>

        <div class="col-md-2">
            <div class="input-group">
                <input class="form-control price" pattern="([0-9]{1,3},[0-9]{1,2})" placeholder="0,00" required/>

                <div class="input-group-addon">zł</div>
            </div>
        </div>

        <div class="col-md-4">
            <input class="form-control desc" placeholder="Dodatkowy opis"/>
        </div>

        <div class="col-md-4 col-lg-offset-4 pp" style="margin-top: 10px;"></div>

    </div>


    <div id="items"></div>
    <div class="row" style="margin-top:20px">
        <div class="col-md-12">
            <button type="button" id="add" class="btn btn-primary">
                <i class="glyphicon glyphicon-plus"></i> Następna gra
            </button>

            <button class="btn bg-primary" id="save" type="submit">Zapisz</button>
        </div>
    </div>




    {{ Form::hidden('ids', null, array('id' => 'ids')) }}
    {{ Form::hidden('prices', null, array('id' => 'prices')) }}
    {{ Form::hidden('desc', null, array('id' => 'desc')) }}

    {!! Form::close() !!}

@stop


@section('script')

    <script src="{{ URL::asset('ui/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('easy-autocomplete/easy-autocomplete.js') }}"></script>


    <script>

        $('.show').click(function () {
            $('.temp1').removeClass('temp1');
            $('.temp2').removeClass('temp2');
            $(this).addClass("temp1");
            $(this).parent().parent().find($('.hiddenn')).addClass("temp2");

        });


        var options = {
            url: function (phrase) {
                return "http://steam.dbronczyk.pl/json/" + phrase;
            },
            getValue: function (element) {
                return element.name;
            },
            requestDelay: 300,
            template: {
                type: "iconLeft",
                fields: {
                    iconSrc: function (element) {
                        return "http://cdn.akamai.steamstatic.com/steam/apps/" + element.appid + "/header.jpg";
                    },
                },
            },
            list: {
                match: {
                    enabled: true
                },
                maxNumberOfElements: 5,
                onClickEvent: function () {
                    var value = $(".temp1").getSelectedItemData().appid;
                    $(".temp2").val(value).trigger("change");

                    $.getJSON('http://steam.dbronczyk.pl/price/' + value, {
                        format: "json"
                    }).done(function (data) {

                        var a = $(".temp2").parent().parent().find('.pp');
                        console.log(a);
                        a.find('p').remove();

                        if (data.min == null) {
                            a.append("<p><span class='label label-primary' data-toggle='tooltip' data-placement='bottom' title='Ta gra nie została jeszcze sprzedana'>Brak</span></span></p>").tooltip();
                        } else {
                            a.append("<p><span class='label label-primary' data-toggle='tooltip' data-placement='bottom' title='Najniższa cena, za którą sprzedano grę.'>" + data.min + "</span></span></p>").tooltip();
                        }


                    }).fail(function () {
                        var a = $(".temp2").parent().parent().find('.pp');
                        console.log(a);
                        a.find('p').remove();
                        a.append("<p>Brak</p>");
                    });

                }

            },

        };

        $('.show').easyAutocomplete(options);


    </script>



    <script>
        //when the Add Field button is clicked


        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })


        var i = 2;

        $("#add").click(function (e) {

            if (i < 11) {
                $("#items").append('' +
                        '<div class="row" id="' + i + '" style="margin-top:10px; margin-bottom:10px;">' +
                        '' +
                        '<div class="col-md-4">' +
                        '<input type="text" data-autocomplete class="form-control show" placeholder="Nazwa gry" name="field' + i + '" required/>' +
                        '<input class="hiddenn" type="hidden"/>' +
                        '</div>' +
                        '' +
                        '<div class="col-md-2">' +
                        '<div class="input-group">' +
                        '<input class="form-control price" pattern="[0-9]{1,},[0-9]{2}" placeholder="Cena" required/>' +
                        '<div class="input-group-addon">zł</div>' +
                        '</div>' +
                        '</div>' +
                        '' +
                        '<div class="col-md-4">' +
                        '<input class="form-control desc" placeholder="Dodatkowy opis"/>' +
                        '</div>' +
                        '' +
                        '<div class="col-md-1">' +
                        '<button type="button" class="delete btn btn-danger">' +
                        '<i class="glyphicon glyphicon-minus"></i>' +
                        '</button>' +
                        '</div>' +
                        '<div class="col-md-4 col-lg-offset-4 pp" style="margin-top: 10px;"></div>' +
                        '</div>' +
                        '' +
                        '</div>'
                ).find('.show').easyAutocomplete(options);

                $('#' + i).hide().show('normal');
                i++;


                $('.show').click(function () {
                    $('.temp1').removeClass('temp1');
                    $('.temp2').removeClass('temp2');
                    $(this).addClass("temp1");
                    $(this).parent().parent().find($('.hiddenn')).addClass("temp2");

                });


            }
            else {
                $('#add').prop('disabled', true);
                alert('Za dużo tego!');
            }


        });

        //usuwanie
        $("body").on("click", ".delete", function (e) {
            var id = $(this).parent("div").parent("div").attr("id");
            $(this).parent("div").parent("div").slideUp("fast", "linear", function () {
                $(this).remove();
            });
            i--;

            if (i < 11) {
                $('#add').prop('disabled', false);
            }
        });

        //zapis danych
        $("#save").click(function () {
            var id = '';
            var price = '';
            var desc = '';
            $('.hiddenn').each(function (index) {
                id = id + $(this).val() + ';';
            });
            $('.price').each(function (index) {
                price = price + $(this).val() + ';';
            });
            $('.desc').each(function (index) {
                desc = desc + $(this).val() + ';';
            });
            $('#ids').val(id);
            $('#prices').val(price);
            $('#desc').val(desc);

        });

    </script>


@stop