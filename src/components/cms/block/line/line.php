<!-- HTML Document -->

<div :class="[componentClass, 'bbn-w-100']">
  <div v-if="mode === 'edit'"
       class="bbn-button-group">
    <bbn-button :text="_('TOP')" 
                @click="line = 'top'" 
                :class="{'bbn-state-active': line === 'top'}"/>
    <bbn-button	:text="_('BOTTOM')"
                @click="line = 'bottom'"
                :class="{'bbn-state-active': line === 'bottom'}"/>
    <bbn-button :text="_('BOTH')"
                @click="line = 'both'"
                :class="{'bbn-state-active': line === 'both'}"/>
    <bbn-button :text="_('NONE')"
                @click="line = null"
                :class="{'bbn-state-active': !line}"/>
  </div>
  <div v-else
       class="bbn-w-100">
    <hr v-if="['both', 'top', true].includes(line)">
    <slot></slot>
    <hr v-if="['both', 'bottom', true].includes(line)">
  </div>
</div>