

<html>
<body>

// Put the YUI seed file on your page.
<script src="http://yui.yahooapis.com/3.4.1/build/yui/yui-min.js"></script>

<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->

<div id="demo"></div>
<button id="demo-run">run</button>

<script type="text/javascript">
(function() {
    var attributes = {
        points: { to: [600, 10] }
    };
    var anim = new YAHOO.util.Motion('demo', attributes);

    YAHOO.util.Event.on('demo-run', 'click', function() {
        anim.animate();
    });

    YAHOO.log("The example has finished loading; as you interact with it, you'll see log messages appearing here.", "info", "example");
})();
</script>

<!--END SOURCE CODE FOR EXAMPLE =============================== -->



</body>
</html>

