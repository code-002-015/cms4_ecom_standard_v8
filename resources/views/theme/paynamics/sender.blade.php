<div style="display: none;">
    <form id="paynamicsForm" method="post" action="{{ Setting::paynamics_merchant()['url'] }}">
        <input type="text" name="paymentrequest" id="paymentrequest" value="{{ $base64Code }}">
        <input type="submit">
    </form>
    <script>
        document.getElementById("paynamicsForm").submit();
    </script>
</div>
