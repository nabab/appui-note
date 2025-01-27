<!-- HTML Document -->

<div :class="componentClass">
  <bbn-input bbn-model="source.url"
             :nullable="urlEdited"
             :disabled="disabled"
             :readonly="readonly"
             :pref="pref"
             class="bbn-w-100"
             :button-right="readonly ? '' : 'nf nf-fa-refresh'"
             :action-right="updateURL"
             :required="true"/>
</div>