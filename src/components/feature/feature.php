<!-- HTML Document -->

<div class="bbn-w-100 bbn-spadding"
     v-if="featureItems.length">
  <div class="bbn-spadding"
       v-for="item in featureItems">
    <div v-text="item.title"/>
  </div>
</div>