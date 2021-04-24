<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1>Aktuator LED</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="led-red" onchange="switch_led(this,'red')">
                    <label class="form-check-label" for="led-red">LED Red</label>
                </div>
            </div>
            <div class="row">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="led-green" onchange="switch_led(this,'green')">
                    <label class="form-check-label" for="led-green">LED Green</label>
                </div>
            </div>
            <div class="row">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="led-blue" onchange="switch_led(this,'blue')">
                    <label class="form-check-label" for="led-blue">LED Blue</label>
                </div>
            </div>
            <div class="row">
                <div class="alert alert-info" role="alert">
                    Silakan geser checkbox di sebelah untuk menghidupkan dan mematikan LED
                </div>
            </div>
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
    var MQTTsubTopic = 'control/#'; //works with wildcard # and + topics dynamically now
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
        console.log(message.destinationName, '', message.payloadString);
    };

    //check if a real number	
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    };

    //function that is called once the document has loaded
    function init() {

        // Connect to MQTT broker
        client.connect(options);

    };

    function switch_led(checkboxObj, led) {
        var value;
        if (led == 'red') {
            if (checkboxObj.checked) {
                value = 'true';
            } else {
                value = 'false';
            }
        } else if (led == 'green') {
            if (checkboxObj.checked) {
                value = 'true';
            } else {
                value = 'false';
            }
        } else {
            if (checkboxObj.checked) {
                value = 'true';
            } else {
                value = 'false';
            }
        }

        console.log(led, '', value);
        var topicMessage = new Paho.MQTT.Message(value);
        topicMessage.destinationName = "control/lamp";
        client.send(topicMessage);
    }
</script>
<script>
    init()
</script>
<?= $this->endSection(); ?>