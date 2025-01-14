<!-- HTML Document -->

<div>
  <bbn-button icon="nf nf-fa-align_left"
              :label="_('Align left')"
              :notext="true"
              @click="align = 'left'"
              :class="{'bbn-state-active': align === 'left'}"/>
  <bbn-button icon="nf nf-fa-align_center"
              :label="_('Align center')"
              :notext="true"
              @click="align = 'center'"
              :class="{'bbn-state-active': align === 'center'}"/>
  <bbn-button icon="nf nf-fa-align_right"
              :label="_('Align right')"
              :notext="true"
              @click="align = 'right'"
              :class="{'bbn-state-active': align === 'right'}"/>
</div>