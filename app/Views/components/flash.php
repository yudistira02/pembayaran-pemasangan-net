<?php if(session()->has('success')): ?>
<div id="successMessage" class="bg-green-500 text-white rounded-lg p-2 text-center">
    <?= session('success') ?>
</div>
<?php elseif(session()->has('error')): ?>
<div id="errorMessage" class="bg-red-500 text-white rounded-lg p-2 text-center">
    <?= session('error') ?>
</div>
<?php endif; ?>

<script>
    // Function to fade out a message after 3 seconds
    function fadeOutMessage(messageId) {
        setTimeout(function() {
            var message = document.getElementById(messageId);
            message.style.transition = "opacity 1s";
            message.style.opacity = "0";
            setTimeout(function() {
                message.style.display = "none";
            }, 1000);
        }, 3000);
    }

    // Call fadeOutMessage for success and error messages
    if (document.getElementById('successMessage')) {
        fadeOutMessage('successMessage');
    }
    if (document.getElementById('errorMessage')) {
        fadeOutMessage('errorMessage');
    }
</script>
