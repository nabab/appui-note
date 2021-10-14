// Javascript Document

(() => {
  if (!bbn.vue.mixins) {
    bbn.vue.mixins = {};
  }

  let setStyle = function(name, value) {
    if (this.ready) {
      let style = this.source.style || {};

      // Checking if the name is not in the CSS form (no camelCase)
      if (style[name] === undefined) {

        let tmp = bbn.fn.camelToCss(name);
        if (style[tmp] !== undefined) {
          name = tmp;
        }
        // If none defined prefering the camelCase form
        else {
          name = bbn.fn.camelize(name);
        }
      }

      // Checking if the value is different
      if (style[name] !== value) {
        if (style[name] !== undefined) {
          this.source.style[name] = value;
        }
        else if (value) {
          if (!this.source.style) {
            this.$set(this.source, 'style', {});
          }

          this.$set(this.source.style, name, value);
          this.$forceUpdate();
        }
      }
    }
  };

  bbn.vue.mixins['appui-note-cms-reader'] =
    {
      props: {
        source: {},
      },
      data(){
        return {
          //cp video
          muted: true,
          autoplay: false,
          align: '',
          image: [],
          tinyNumbers: [{text: '1', value: 1}, {text: '2', value: 2},{text: '3', value: 3},{text: '4', value: 4}],
          ref: (new Date()).getTime(),
          show: true,
          currentCarouselIdx: 0
        }
      },
      computed: {
        isAutoplay(){
          return this.autoplay === true;
        },
        edit(){
          return this.$parent.edit
        },
        path(){
          return this.$parent.path
        },
        linkURL(){
          return this.$parent.linkURL
        },
        mobile(){
          if ( bbn.env.width <= 640 ){
            this.$parent.isMobile = true;
            return true;
          }
          return false
        },
        alignClass(){
          let st = 'bbn-c';
          if ( this.source.align === 'left' ){
            st = 'bbn-l'
          }
          if ( this.source.align === 'right' ){
            st = 'bbn-r'
          }
          return st;
        },
        styleProps(){
          return Object.keys(this.source.style || {});
        },
        currentStyle(){
          let res = {};
          bbn.fn.each(this.styleProps, n => {
            res[bbn.fn.camelize(n)] = this.source.style[n];
          });

          return res;
        },
        style(){
          let st = '';
          if (this.source.style){
            return this.currentStyle;
          }

          return st;
        }
      }, 
      methods: { 
        setStyle: setStyle,
      },
      mounted() {
        this.ready = true;
      },
    	watch: {
        "source.style": {
          deep: true,
          handler(){
            bbn.fn.log("CHANGING SOURCE STYLE");
          }
        }
      }
    };

  bbn.vue.mixins['appui-note-cms-editor'] =
    {
      props: {
        source: {},
      },
      data(){
        return {
          muted: true,
          autoplay: false,
          align: '',
          image: [],
          tinyNumbers: [{text: '1', value: 1}, {text: '2', value: 2},{text: '3', value: 3},{text: '4', value: 4}],
          ref: (new Date()).getTime(),
          show: true,
          currentCarouselIdx: 0
        }
      },
      computed: {
        edit(){
          return this.$parent.edit
        },
        path(){
          return this.$parent.path
        },
        linkURL(){
          return this.$parent.linkURL
        },
        alignClass(){
          if (this.source.align === 'left') {
            return 'bbn-l'
          }
          else if (this.source.align === 'right') {
            return 'bbn-r'
          }

          return 'bbn-c';
        },
        styleProps(){
          return Object.keys(this.source.style || {});
        },
        currentStyle(){
          let res = {};
          bbn.fn.each(this.styleProps, n => {
            res[bbn.fn.camelize(n)] = this.source.style[n];
          });

          return res;
        },
        style(){
          let st = '';
          if (this.source.style){
            return this.currentStyle;
          }

          return st;
        }
      },
      methods: {
        setStyle: setStyle,
      },
      mounted() {
        this.ready = true;
      }
    };

  return {
    /**
     * @mixin bbn.vue.basicComponent
     */
    mixins: [bbn.vue.basicComponent, bbn.vue.resizerComponent],
    props: {
      /**
       * The aduio's URL
       */
      source: {
        type: Object,
        required: true
      },
      index: {
        type: Number,
      },
      //the path for the index showing the images ('ex: image/')
      path: {
        type: String,
        default: ''
      },
      //the path for the links (give a path to a controller to manage the links)
      linkURL: {
        type: String,
        default: ''
      },
      editable: {
        type: Boolean,
        default: false
      },
      selectable: {
        type: Boolean,
        default: false
      },
      selected: {
        type: Boolean,
        default: false
      },
      overable: {
        type: Boolean,
        default: false
      },
      mode: {
        type: String,
        default: 'read'
      },
    },
    data(){
      return {
        over: false,
        edit: this.mode === 'edit',
        isAdmin: true,
        editing: true,
        width: '100%',
        height: '100%',
        //ready is important for the component template to be defined
        ready: true,
        initialSource: null
      }
    },
    computed: {
      isSelected() {
        return this.selected === true;
      },
      currentComponent(){
        return this.getComponentName((this.edit ? 'editor' : 'reader') + '/' + this.type);
      },
      changed(){
        return this.ready && !bbn.fn.isSame(this.initialSource, this.source);
      },
      type(){
        return this.source.type || text
      },
      parent(){
        return this.ready ? this.closest('bbn-container').getComponent() : null;
      }
    },
    methods: {
      selectImg(st){
        bbn.fn.link(st);
      },
      /**
       * adds the events listener when edit = true
       * @param {boolean} edit 
       */
      _setEvents(){
        bbn.fn.log("setEvent")
        /*
        document.addEventListener('mousedown', this.checkMouseDown);
        document.addEventListener('touchstart', this.checkMouseDown);
        document.addEventListener('keydown', this.checkKeyCode);
        /*if ( edit ){
          document.addEventListener('mousedown', this.checkMouseDown);
          document.addEventListener('touchstart', this.checkMouseDown);
          document.addEventListener('keydown', this.checkKeyCode);
        }
        else{
          document.addEventListener('mouseover', this.mouseover);
          document.removeEventListener('mousedown', this.checkMouseDown);
          document.removeEventListener('touchstart', this.checkMouseDown);
        }*/
      },
      checkKeyCode(e){
        bbn.fn.log("checkKeyCode")
        if ( e.keyCode === 27 ){
          this.edit = false;
        }
      },
      /**
       * set edit to false
       * @param {event} e 
       */
      checkMouseDown(e){
        if ( !e.target.closest(".bbn-cms-block-edit") ){
          /*e.preventDefault();
          e.stopImmediatePropagation();*/
          this.edit = false;
          alert(this.edit)
        }
        else{
          alert(this.edit)
          this.editMode();
        }
      },
      editBlock(){
        bbn.fn.log("editBlock")
        if ( this.changed ){
          appui.success(bbn._('Block changed'))
          //add a confirm
          if (!this.editable) {
            return;
          }
          this.$nextTick(()=>{
            this.edit = false;
          })
        }
        else if (this.editable) {
          this.edit = false;
        }
      },
      cancelEdit(){
        bbn.fn.log("cancelEdit")
        bbn.fn.iterate(this.initialSource, (v, i)=>{
          this.source[i] = v;
          if (this.editable) {
	          this.edit = false;
          }
        })
      },
      editMode(){
        if (!this.editable) {
          return;
        }

        bbn.fn.log("editMode")
        let blocks = this.closest('bbn-container').getComponent().findAll('bbn-cms-block');
        bbn.fn.each(blocks, (v, i)=>{
          v.edit = false;
          v.over = false;
        })
        this.edit = true;
      },
    },
    mounted(){
      this.ready = true;
    },
    watch: {
      changed(){
        bbn.fn.log("changed")
      },
      type(){
        bbn.fn.log("type")
      },
      edit(val){
      }
    }
  };
})();