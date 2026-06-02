<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
    <script>
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        if (/android/i.test(userAgent)) {
            window.location.href = "{{ $android->link ?? '#' }}";
        } else if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            window.location.href = "{{ $ios->link ?? '#' }}";
        } else {
            window.location.href = "{{ url('/') }}"; // رابط افتراضي
        }
    </script>
</head>
<body>
    <p>Redirecting...</p>
</body>
</html>
