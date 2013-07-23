<form action="/tournamentLoader/processimport" method="post" enctype="multipart/form-data">
    <input type="hidden" name="importtype" value="csv" />
    <div class="row">
        <label for="contactsfile">Contacts File:</label>
        <input type="file" id="contactsfile" name="contactsfile" />
    </div>
    <div class="row">
        <label for="submit"> </label>
        <input id="submit" type="submit" class="submitbutton" value="Upload" />
    </div>
</form>