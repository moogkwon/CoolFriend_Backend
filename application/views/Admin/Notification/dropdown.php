<?php if(isset($states)) { ?>
<option value="0">State</option>
<?php foreach($states as $key=>$state) { ?>
<option value="<?php echo $state->state_id; ?>"><?php echo $state->state_name; ?></option>
<?php } ?>
<?php } ?>
<?php if(isset($cities)) { ?>
<option value="0">City</option>
<?php foreach($cities as $key=>$city) { ?>
<option value="<?php echo $city->city_id; ?>"><?php echo $city->city_name; ?></option>
<?php } ?>
<?php } ?>