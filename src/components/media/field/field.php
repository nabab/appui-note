<!-- HTML Document -->

<div :class="componentClass">
  <div class="bbn-w-100 bbn-flex">
    <div class="bbn-right-margin">
      <div class="bbn-iblock bbn-bottom-smargin">
        <bbn-button icon="nf nf-fae-galery"
                    :notext="true"
                    @click="openGallery"
                    title="<?= _('Browse the images') ?>"/>
      </div><br>
      <div class="bbn-iblock bbn-bottom-smargin">
        <bbn-button bbn-if="currentIndex > -1"
                    icon="nf nf-mdi-information_outline"
                    :notext="true"
                    @click="openInfo(source[currentIndex])"
                    title="<?= _('Show media information') ?>"/>
      </div>
    </div>
    <div>
      <img bbn-if="value"
           class="bbn-border bbn-radius bbn-p"
           @click="showImage()"
           style="max-height: 8em; width: min(auto, 100%); max-width: 8em; height: min(auto, 100%)"
           :src="root + 'media/image/' + value + '?w=200'">
    </div>
  </div>
  <div bbn-if="source !== undefined"
       class="bbn-w-100 bbn-flex-items"
       style="flex-wrap: wrap; gap: var(--sspace)">
    <div bbn-for="(img, i) in source"
         class="bbn-p"
         @click="emitInput(img.id)"
         @mouseenter="overImg = img.id"
         @mouseleave="overImg = null"
         style="min-width: 5em; minHeight: 5em">
      <div class="bbn-100 bbn-vmiddle">
        <img class="bbn-border bbn-radius"
             style="max-height: 5em; width: min(auto, 100%); max-width: 5em; height: min(auto, 100%)"
             :src="root + 'media/image/' + img.id + '?w=200'">
        <div class="bbn-bottom-left bbn-w-100 bbn-modal bbn-white bbn-c"
             style="height: 1.5em"
             bbn-show="overImg === img.id"
             @click.stop>
          <div class="bbn-iblock bbn-xspadding bbn-p bbn-text-reactive"
               @click="showImage(img)">
            <i class="nf nf-mdi-magnify_plus_outline"/>
          </div>
          <div class="bbn-iblock bbn-xspadding bbn-p bbn-text-reactive"
               @click="openInfo(img)">
            <i class="nf nf-mdi-information"/>
          </div>
        </div>
      </div>
    </div>
    <!--div class="bbn-p"
         @click="() => {}"
         style="min-width: 5em; minHeight: 5em">
      <div class="bbn-100 bbn-middle">
        <div class="bbn-border bbn-radius bbn-middle bbn-50 bbn-primary">
          <div class="bbn-iblock bbn-xspadding bbn-p bbn-text-reactive bbn-lg bbn-b"
               @click="() => {}">
            <i class="nf nf-mdi-plus"/>
          </div>
        </div>
      </div>
    </dibbn-->
  </div>
</div>
