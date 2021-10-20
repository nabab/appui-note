// Javascript Document

(() => {
  if (!bbn.vue.mixins) {
    bbn.vue.mixins = {};
  }

  bbn.vue.mixins['appui-note-cms-block'] = {
    props: {
      source: {
        type: Object,
        default(){
          return {};
        }
      },
      mode: {
        type: String,
        default: 'read'
      }
    },
    data(){
      return {
        show: true,
      }
    },
    computed: {
      isEditor(){
        return this.mode === 'edit';
      }
    },
    methods: {
      setSource(prop, val) {
        if (!val) {
          delete this.source[prop];
        }
        else {
          this.$set(this.source, prop, val);
        }
      }
    },
    mounted() {
      this.ready = true;
    },
    source: {
      deep: true,
      handler(){
        if (!this.isEditor) {
          let cp = this.getRef('component');
          if (cp) {
            cp.$forceUpdate();
          }
        }
      }
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
        width: '100',
        height: '100',
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
        return this.getComponentName(this.type);
      },
      changed(){
        return this.ready && !bbn.fn.isSame(this.initialSource, this.source);
      },
      type(){
        return this.source.type || 'text'
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
    },
    mounted(){
      this.ready = true;
    },
    watch: {
      currentComponent(v) {
        bbn.fn.log(v, JSON.stringify(this.source));
        this.ready = false;
        setTimeout(() => {
          this.ready = true;
        }, 100)
      }
    }
  };
})();