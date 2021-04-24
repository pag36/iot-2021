<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div id="container-speed"></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div id="chart-suhu"></div><!-- this the placeholder for the chart-->
        </div>
        <div class="col">
            <div id="chart-humadity"></div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<!-- template sensor -->
<?= $this->section('script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/paho-mqtt/1.0.1/mqttws31.min.js" type="text/javascript"></script>
<script type="text/javascript">
    var MQTTbroker = 'broker.sinaungoding.com';
    var MQTTport = 8089;
    var MQTTsubTopic = 'room/#'; //works with wildcard # and + topics dynamically now
    var chart; // global variuable for chart
    var chartHum;
    var chartLamp;
    var dataTopics = new Array();
    var dataTopicsHum = new Array();
    //mqtt broker
    var client = new Paho.MQTT.Client(MQTTbroker, MQTTport, "jti_" + parseInt(Math.random() * 100, 10));
    client.onMessageArrived = onMessageArrived;
    client.onConnectionLost = onConnectionLost;

    //mqtt connecton options including the mqtt broker subscriptions
    var options = {
        timeout: 3,
        useSSL: false,
        onSuccess: function() {
            console.log("mqtt connected");
            // Connection succeeded; subscribe to our topics
            client.subscribe(MQTTsubTopic, {
                qos: 1
            });
        },
        onFailure: function(message) {
            console.log("Connection failed, ERROR: " + message.errorMessage);
            //window.setTimeout(location.reload(),20000); //wait 20seconds before trying to connect again.
        }
    };
    //can be used to reconnect on connection lost
    function onConnectionLost(responseObject) {
        console.log("connection lost: " + responseObject.errorMessage);
        //window.setTimeout(location.reload(),20000); //wait 20seconds before trying to connect again.
    };
    //what is done when a message arrives from the broker

    function onMessageArrived(message) {
        // console.log(message.destinationName, '', message.payloadString);

        //check if it is a new topic, if not add it to the array
        // if (dataTopics.indexOf(message.destinationName) < 0) {
        //     dataTopics.push(message.destinationName); //add new topic to array
        //     var y = dataTopics.indexOf(message.destinationName); //get the index no
        //     //create new data series for the chart
        //     var newseries = {
        //         id: y,
        //         name: message.destinationName,
        //         data: []
        //     };
        //     console.log(newseries);
        //     chart.addSeries(newseries); //add the series

        // };

        // var y = dataTopics.indexOf(message.destinationName); //get the index no of the topic from the array
        // var myEpoch = new Date().getTime(); //get current epoch time
        // var thenum = message.payloadString.replace(/^\D+/g, ''); //remove any text spaces from the message
        // var plotMqtt = [myEpoch, Number(thenum)]; //create the array
        // if (isNumber(thenum)) { //check if it is a real number and not text
        //     // console.log('is a propper number, will send to chart.')
        //     plot(plotMqtt, 0, message.destinationName); //send it to the plot function
        // };

        if (message.destinationName == 'room/lamp') {
            var point,
                inc, series;
            point = chartLamp.series[0].points[0];
            inc = message.payloadString.replace(/^\D+/g, '');
            // update series
            var value = Number(inc);
            if (value > 0 && value <= 341) {
                series = 'Gelap';
            } else if (value > 341 && value <= 682) {
                series = 'Redup';
            } else {
                series = 'Terang';
            }
            chartLamp.series[0].name = series;
            chartLamp.series[0].isDirty = true; // force update tooltips
            chartLamp.isDirty = true; // force update legend
            chartLamp.redraw();
            point.update(value);
        } else {
            var myEpoch = new Date().getTime(); //get current epoch time
            var thenum = message.payloadString.replace(/^\D+/g, ''); //remove any text spaces from the message
            var plotMqtt = [myEpoch, Number(thenum)]; //create the array
            if (isNumber(thenum)) { //check if it is a real number and not text
                // console.log('is a propper number, will send to chart.')
                plot(plotMqtt, 0, message.destinationName); //send it to the plot function
            };
        }
    };

    //check if a real number	
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    };

    //function that is called once the document has loaded
    function init() {

        //i find i have to set this to false if i have trouble with timezones.
        Highcharts.setOptions({
            global: {
                useUTC: false
            }
        });

        // Connect to MQTT broker
        client.connect(options);

    };


    //this adds the plots to the chart	
    function plot(point, chartno, topics) {
        console.log(point, '', topics);

        if (topics == 'room/suhu') {
            var series = chart.series[0],
                shift = series.data.length > 20;
            chart.series[chartno].addPoint(point, true, shift);
        } else if (topics == 'room/hum') {
            var series = chartHum.series[0],
                shift = series.data.length > 20;
            chartHum.series[chartno].addPoint(point, true, shift);
        }
        // var series = chart.series[0],
        //     shift = series.data.length > 20; // shift if the series is 
        // longer than 20
        // add the point
        // chart.series[chartno].addPoint(point, true, shift);
        // chartHum.series[chartno].addPoint(point, true, shift);

    };

    // chart suhu
    $(document).ready(function() {

        // chart suhu
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'chart-suhu',
                defaultSeriesType: 'spline'
            },
            title: {
                text: 'Suhu Live Websockets'
            },
            subtitle: {
                text: MQTTbroker + ' | port: ' + MQTTport + ' | topic : ' + 'room/suhu',
                align: 'center'
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 20 * 1000
            },
            yAxis: {
                minPadding: 0.2,
                maxPadding: 0.2,
                title: {
                    text: 'Nilai',
                    margin: 10
                }
            },
            series: [{
                name: 'room/suhu'
            }]
        });

        // chart humadity
        chartHum = new Highcharts.Chart({
            chart: {
                renderTo: 'chart-humadity',
                defaultSeriesType: 'spline'
            },
            title: {
                text: 'Humadity Live Websockets'
            },
            subtitle: {
                text: MQTTbroker + ' | port: ' + MQTTport + ' | topic : ' + 'room/hum',
                align: 'center'
            },
            exporting: {
                enabled: false
            },
            xAxis: {
                type: 'datetime',
                tickPixelInterval: 150,
                maxZoom: 20 * 1000
            },
            yAxis: {
                minPadding: 0.2,
                maxPadding: 0.2,
                title: {
                    text: 'Nilai',
                    margin: 10
                }
            },
            series: [{
                name: 'room/hum'
            }]
        });

        var gaugeOptions = {
            chart: {
                type: 'solidgauge'
            },

            title: {
                text: 'Cahaya Live Websockets'
            },

            subtitle: {
                text: MQTTbroker + ' | port: ' + MQTTport + ' | topic : ' + 'room/lamp',
                align: 'center'
            },

            pane: {
                // center: ['50%', '85%'],
                // size: '100%',
                startAngle: -150,
                endAngle: 150,
                background: {
                    backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || '#EEE',
                    innerRadius: '60%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            exporting: {
                enabled: false
            },

            tooltip: {
                enabled: true
            },

            // the value axis
            yAxis: {
                stops: [
                    [0.1, '#55BF3B'], // green
                    [0.5, '#DDDF0D'], // yellow
                    [0.9, '#DF5353'] // red
                ],
                lineWidth: 0,
                tickWidth: 0,
                minorTickInterval: null,
                tickAmount: 2,
                title: {
                    y: -70
                },
                labels: {
                    y: 16
                }
            },

            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        y: 5,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };

        // The speed gauge
        chartLamp = Highcharts.chart('container-speed', Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 1024,
                // title: {
                //     text: 'Intensitas Cahaya'
                // }
            },


            series: [{
                name: 'lux',
                data: [0],
                dataLabels: {
                    format: '<div style="text-align:center">' +
                        '<span style="font-size:25px">{y}</span><br/>' +
                        '<span style="font-size:12px;opacity:0.4">Lux</span>' +
                        '</div>'
                },
                tooltip: {
                    valueSuffix: ' '
                }
            }]

        }));

    });
</script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    init()
</script>
<?= $this->endSection(); ?>