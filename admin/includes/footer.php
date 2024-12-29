</div>
<!-- /#wrapper -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
    ClassicEditor
        .create(document.querySelector('#editor')).then(editor => {
            editor.editing.view.change(writer => {
                writer.setStyle('min-height', '200px', editor.editing.view.document.getRoot());
            });
            window.editor = editor;
        })
        .catch(error => {
            console.error(error);
        });
</script>

<script>
    function selectAll(source) {
        var checkboxes = document.querySelectorAll('#viewposts input[type="checkbox"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }
</script>
</body>
</html>