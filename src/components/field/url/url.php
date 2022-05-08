<!-- HTML Document -->

<div :class="componentClass">
  <bbn-input v-model="source.url"
             :nullable="urlEdited"
             :disabled="disabled"
             :readonly="readonly"
             :prefix="prefix"
             class="bbn-w-100"
             :button-right="readonly ? '' : 'nf nf-fa-refresh'"
             :action-right="updateURL"
             :required="true"/>
</div>