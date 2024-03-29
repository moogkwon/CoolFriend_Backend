<?php $this->load->view('client/layout/header'); ?>


<!-- Page content-->
<div class="content-wrapper">
    <div class="content-heading">
        <div>Campaign
            <small>Participate in Campaign</small>
        </div>
    </div>
    <!-- START card-->
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs" role="tablist" id="campaign-tab">
                <?php
                    for($tabId = 0 ; $tabId < count($campaign_tabs) ; $tabId++){
                        $tabName = $campaign_tabs[$tabId]; ?>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?=$tabName.($tabId == 0 ? " active show" : "")?>" href="#tab-<?=$tabId?>" 
                                aria-controls="home" role="tab" data-toggle="tab"><?=$tabName?>
                            </a>
                        </li>
                    <?php }
                ?>
            </ul>
            <div class="tab-content">
            <?php
                $errList = array(
                    "",
                    "Done.",
                    "Set your ID in profile.",
                    "Set Eth address in profile."
                );
                for($tabId = 0 ; $tabId < count($campaign_tabs) ; $tabId++) {
                    $tabName = $campaign_tabs [$tabId];
                    echo '<div class="tab-pane fade '.($tabId == 0 ? "active show" : "").'" id="tab-'.$tabId.'" role="tabpanel">
                            <div class="row">';

                    for($campId = 0 ; $campId < count($campaign_data) ; $campId++){
                        $cell = $campaign_data [$campId];
                        if ($cell ["tab_id"] != $tabId) continue;

                        $errCode = 0;
                        if ($campStatus ["count_".$campId] >= $cell ["count"])   $errCode = 1;
                        else if (!isset($this->session->userdata("user")->social_accounts[$tabName])
                            || $this->session->userdata("user")->social_accounts[$tabName] == "")
                                $errCode = 2;
                        else if ($this->session->userdata("user")->eth_address == "")
                            $errCode = 3;
                        ?>
                        <div class="col-md-6">
                            <div class="card card-default">
                                <div class="card-header">
                                    <h4><?=$cell['text']?>
                                        <div class="float-right badge badge-success">+<?=$cell ["score"]?></div>
                                    </h4>
                                    <small><?=getCampaignCountDesc($cell["count"], $cell["canRepeat"])?></small>
                                </div>
                                <div class="card-body">
                                    <div class="row py-4 justify-content-center">
                                        <div class="col-lg-12">
                                            <form class="form-horizontal" action="<?=base_url()?>client/campaign/submit_campaign" method="post">
                                                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
                                                <input name="campaign_id" type="hidden" value="<?=$campId?>">
                                                
                                                <div class="form-group row">
                                                    <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right">URL</label>
                                                    <div class="col-xl-10 col-md-9 col-8 mt-2">
                                                        <a href="<?=$cell['url']?>" class="pg-link" target="_blank">
                                                            <?=$cell['url']?></a>
                                                    </div>
                                                </div>

                                                <?php if ($cell['comment']) { ?>
                                                    <div class="form-group row">
                                                        <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right" for="inputNotes">Notes</label>
                                                        <div class="col-xl-10 col-md-9 col-8">
                                                            <textarea class="form-control" id="inputNotes" rows="4" name="note" placeholder="Message to Admin"></textarea>
                                                        </div>
                                                    </div>
                                                <?php }?>
                                                <?php if ($errCode != 0) { ?>
                                                <div class="form-group row">
                                                    <label class="text-bold col-xl-2 col-md-3 col-4 col-form-label text-right"></label>
                                                    <div class="col-xl-10 col-md-9 col-8">
                                                        <div class="alert alert-warning p-0 pl-2"><?=$errList [$errCode]?></div>
                                                    </div>
                                                </div>
                                                <?php }?>
                                                <div class="form-group row">
                                                    <div class="col-md-12 text-center">
                                                        <a href="<?=$cell['url']?>" target="_blank">
                                                            <button class="btn btn-primary" type="button">Join Us</button>
                                                        </a>
                                                        <button class="btn btn-info" type="submit" <?=$errCode == 0 ? "" : "disabled"?>>Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } 
                    echo '</div></div>';
                }
            ?>
        </div>
    </div>
</div>


<?php $this->load->view('client/layout/footer'); ?>
