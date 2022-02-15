<!-- HTML Document -->

<div :class="componentClass">
  <bbn-input v-model="source.url"
             :nullable="urlEdited"
             :prefix="prefix"
             class="bbn-w-100"
             :required="true"/>
</div>