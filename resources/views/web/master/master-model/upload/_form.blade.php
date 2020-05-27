<form id="form-upload-master-model" class="mr-3 ml-3">
  <h5>Upload Model</h5>
  <hr>
  <br>
  <div class="file-field input-field">
    <div class="row">
	  <div class="col s12 m2 l2">
	    <p>Data File</p>
	  </div>
	  <div class="col s12 m10 l10">
	  	<div class="btn btn-small waves-effect">
	        <span>Browse</span>
	        <input type="file" name="file-master-model">
        </div>
	  	<div class="file-path-wrapper">
		    <input class="file-path validate" type="text" placeholder="Select file.."/>
		</div>
		<div>
			<p>Format File : .csv</p>
		    <p>Format Layout Column : <br/>
		    [MODEL NAME],[EANCODE],[CBM UNIT],[MATERIAL GROUP CODE],[CATEGORY],[MODEL_TYPE],[PCS/CTN],[CTN/PLT],[MAX PALET],[DESCRIPTION],[PRICE1],[PRICE2],[PRICE3]</p>
		</div>
	  </div>
    </div>
  </div>
</form>
