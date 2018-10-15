<div id="airdropModal" class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">              
              <h4 class="modal-title" id="myModalLabel">Modal title</h4>
               <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>


            </div>
            <div class="modal-body">
              <form class="form">
                <div class="form-group">
                  <label for="exampleInputEmail1">Url</label>
                  <a href="asdf"><h5 class="modal-url"></h5></a>
                </div>
                <div class="form-group">
                  <label>Note</label>
                  <p class="modal-note"></p>
                </div>
                <div class="form-group">
                  <label>Score</label>
                  <input class="form-control modal-score"/>
                </div>
                <div class="form-group">
                  <label>Message</label>
                  <textarea class="form-control modal-message" rows="5"></textarea>
                </div>
              </form>
            </div>
            <div class="modal-footer">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
               <button class="btn btn-primary modal-button" type="button">Save changes</button>
            </div>
         </div>
      </div>
   </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary modal-button" data-dismiss="modal">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<script>
function showModal(status, id) {
    var title = {
      "-1" : "Reject submit",
      "1" : "Approve submit"
    };
    var btnTitle = {
      "-1" : "Reject",
      "1" : "Approve"
    };
    $(".modal-title").html(title [status]);
    $(".modal-button").html(btnTitle [status]);

    $("#airdropModal").attr("data-id", id);
    $("#airdropModal").attr("data-status", status);

    $.ajax({
      url: "<?=base_url()?>admin/airdrop/getSubmitInfo/" + id,
      method: "get",
      success: function(data) {
        data = $.parseJSON(data);
        $(".modal-url").parent().attr("href", data.url);
        $(".modal-url").html(data.url);

        $(".modal-note").html(data.note);
        $(".modal-score").val(data.score);
        $(".modal-message").val(data.message);

        $("#airdropModal").modal();
      }
    });
}

(function(window, document, $, undefined) {
    $(function() {
      $(".modal-button").bind("click", function(e) {
        var id = $("#airdropModal").attr("data-id");
        var status = $("#airdropModal").attr("data-status");
        var score = $(".modal-score").val();
        var message = $(".modal-message").val();
        
        $.ajax({
          url: "<?=base_url()?>admin/airdrop/changeSubmitStatus/" + id,
          data: "<?=$this->security->get_csrf_token_name()."=".$this->security->get_csrf_hash()?>" +
                "&status=" + status + "&score=" + score + "&message=" + message,
          method: "POST",
          success: function(data) {
            data = JSON.parse(data);
            if (data.result != 1) {
              alert("You can't approve the submit. Max count reached.");
              return;
            }
            $('#airdropModal').modal('hide');
            ajax_datatable.fnClearTable();
          }
        })
    });
  });
})(window, document, window.jQuery);
</script>
