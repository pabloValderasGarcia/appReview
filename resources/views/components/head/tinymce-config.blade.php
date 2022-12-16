<script src="https://cdn.tiny.cloud/1/x9kbyi09c7obyacd65austs6od5bl8298xyikvegn6ehit45/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#messageReview',
        resize: false,
        setup: function (editor) {
            editor.on('change', function (e) {
                editor.save();
            });
    }
    });
</script>