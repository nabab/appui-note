<div class="bbn-overlay bbn-padding">
  <div class="bbn-flex-height">
    <div class="bbn-middle"
         style="padding-bottom: 1em"
    >
      <bbn-initial width="20"
                   height="20"
                   :user-id="source.id_user"
                   style="margin-right: 5px"
      ></bbn-initial>
      <span bbn-text="userName"></span>
      <span style="margin-left: 1em"><i class="nf nf-fa-calendar_alt"></i> {{creationDate}} <i class="nf nf-fa-clock"></i> {{creationTime}}</span>
    </div>
    <div class="bbn-flex-fill bbn-block">
      <bbn-scroll>
        <div class="bbn-padding"
             bbn-html="source.content"
        ></div>
      </bbn-scroll>
    </div>
  </div>
</div>