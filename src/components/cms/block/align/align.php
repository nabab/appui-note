<!-- HTML Document -->

<div>
  <bbn-button icon="nf nf-fa-align_left"
              :title="_('Align left')" 
              :notext="true"
              @click="align = 'left'" 
              :class="{'bbn-state-active': ($parent.source.align === 'left')}"
              ></bbn-button>
  <bbn-button icon="nf nf-fa-align_center" :title="_('Align left')"
              :notext="true" 
              @click="align = 'center'"
              :class="{'bbn-state-active': ($parent.source.align === 'center')}"
              ></bbn-button>
  <bbn-button icon="nf nf-fa-align_right"
              :title="_('Align left')"
              :notext="true" 
              @click="align = 'right'"
              :class="{'bbn-state-active': ($parent.source.align === 'right')}"
              ></bbn-button>
</div>