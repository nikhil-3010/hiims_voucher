<form action="upload.php" method="POST" enctype="multipart/form-data">
    <fieldset>
        <div class="form-group">
            <label for="f_name">Voucher photo *</label>
            <input type="file" name="voucher_photo" class="form-control" required="required" id="voucher_pic">
        </div> 

        <div class="form-group">
            <label for="l_name">Voucher para pic *</label>
            <input type="file" name="voucher_para_pic" class="form-control" required="required" id="para_pic">
        </div> 
       

        <div class="form-group text-center">
            <label></label>
            <button type="submit" class="btn btn-warning">Save <span class="glyphicon glyphicon-send"></span></button>
        </div>            
    </fieldset>
</form>

