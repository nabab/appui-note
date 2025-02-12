/**
 * Created by BBN Solutions.
 * User: Loredana Bruno
 * Date: 19/07/17
 * Time: 16.14
 */
(() => {
  return {
    mixins: [bbn.cp.mixins.basic],
    props: {
      showPinned: {
        type: Boolean,
        default: false
      },
      source: {
        type: Object,
        required: true
      },
      palette: {
        type: Array,
        default() {
          return [
            '#ff6c89',
            '#fbae3c',
            '#3bd7c2',
            '#fd4db0',
            '#fad2da',
            '#fbf7ae',
            '#dae3ea',
            '#a9c6e8',
            '#d6d4df',
            '#cee2d7',
            '#73cac4',
            '#fff9a5',
            '#f9b8bc',
            '#b0cdeb',
            '#ee5f35',
            '#f37d93',
            '#ffd938',
            '#fd4db0',
            '#1dace6',
            '#e7f150',
            '#ffd938'
          ];
        }
      },
      originalPalette: {
        type: Array,
        default() {
          return ['#FBAE3C', '#FD4DB0', '#1CABE3', '#E7F152', '#FFD93A'];
        }
      },
      icon:{
        type: Boolean,
        default: false
      }
    },
    data(){
      return {
        showCfg: false,
        showInfo: false,
        colorIsChanged: false,
        currentBcolor: this.source.bcolor || '#fbf7ae',
        currentFcolor: this.source.fcolor || '#000000',
        currentText: this.source.text || '',
        currentTitle: this.source.title || '',
        currentPinned: this.source.pinned || false,
        currentCreation: this.source.creation || bbn.fn.dateSQL(),
        actualRotation: bbn.fn.randomInt(-30, 30) / 10,
        saveTimeout: false
      }
    },
    computed: {
      isSaved() {
        if (this.currentTitle !== (this.source.title || '')) {
          bbn.fn.log("title bad", this.currentTitle, (this.source.title || ''))
        }
        if (this.html2text(this.currentText) !== this.html2text(this.source.text || '')) {
          bbn.fn.log("text bad", this.currentText, (this.source.text || ''))
        }
        if (this.currentBcolor !== (this.source.bcolor || '#fbf7ae')) {
          bbn.fn.log("bcolor bad", this.currentBcolor, (this.source.bcolor || '#fbf7ae'))
        }
        if (this.currentFcolor !== (this.source.fcolor || '#000000')) {
          bbn.fn.log("fcolor bad", this.currentFcolor, (this.source.fcolor || '#000000'))
        }
        if (this.currentPinned != (this.source.pinned || false)) {
          bbn.fn.log("pinned bad", this.currentPinned, (this.source.pinned || false))
        }

        return (this.currentTitle === (this.source.title || '')) &&
          (this.html2text(this.currentText) === this.html2text(this.source.text || '')) &&
          (this.currentBcolor === (this.source.bcolor || '#fbf7ae')) &&
          (this.currentFcolor === (this.source.fcolor || '#000000')) &&
        	(this.currentPinned == (this.source.pinned || false));
      },
      getStyle() {
        return '-moz-transform: rotate(' + this.actualRotation + 'deg); ' +
          '-webkit-transform: rotate(' + this.actualRotation + '); ' +
          '-o-transform: rotate(' + this.actualRotation + '); ' +
          '-ms-transform: rotate(' + this.actualRotation + 'deg); ' +
          'transform: rotate(' + this.actualRotation + 'deg); ' +
          'backgroundColor: ' + this.currentBcolor + '; ' +
          'color: ' + this.currentFcolor;
      }
    },
    methods: {
      fdate: bbn.fn.fdate,
      html2text: bbn.fn.html2text,
      onClickPostIt() {
        this.$nextTick(() => {
          const editor = this.getRef('editor');
          if (editor) {
            editor.focus();
          }
        });
      },
      getObj() {
        return {
          label: this.currentTitle,
          text: this.currentText,
          bcolor: this.currentBcolor,
          fcolor: this.currentFcolor,
          pinned: this.currentPinned,
        };
      },
      save() {
        if (!this.isSaved) {
          let obj  = this.getObj();
          let o    = bbn.fn.extend({}, this.source, obj);
          let hash = bbn.fn.md5(JSON.stringify(obj));
          this.post(
            appui.plugins['appui-note'] + '/actions/postit/save',
            {
              data: o
            },
            d => {
              if ( d.success ){
                appui.success(bbn._('Post-it saved'));
                let hash2 = bbn.fn.md5(JSON.stringify(this.getObj()));
                if (hash === hash2) {
                  this.$emit('save', d.data)
                }
              }
              else {
                appui.error();
              }
            }
          );
        }
      },
      removeItem() {
        this.post(appui.plugins['appui-note'] + '/actions/delete', {id_note: this.source.id}, d => {
          if ( d.success ){
            appui.success(bbn._('Delete'));
            bbn.fn.log(this.source);
            this.$emit('remove', this.source);
          }
          else{
            appui.error(bbn._('Error while deleting'));
          }
        });
      },
      changeTitle(e){
        //let newVal = this.html2text($(e.target).html());
        let newVal = this.html2text(e.target.innerHTML);
        if (newVal !== this.currentTitle) {
          this.currentTitle = newVal;
        }
      },
      setSaveChrono() {
        clearTimeout(this.saveTimeout);
        this.saveTimeout = setTimeout(() => {
          this.save();
        }, 2000)
      }
    },
    mounted(){
      this.ready = true;
    },
    watch: {
      currentText() {
        this.setSaveChrono();
      },
      currentTitle() {
        this.setSaveChrono();
      },
      currentBcolor() {
        this.setSaveChrono();
      },
      currentFcolor() {
        this.setSaveChrono();
      },
      currentPinned() {
        this.setSaveChrono();
      }
    }
  }
})();
