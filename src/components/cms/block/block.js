// Javascript Document

(() => {
  bbn.cp.mixins['appui-note-cms-block'] = {
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
      },
      cfg: {
        type: Object,
        default() {
          return {};
        }
      },
      special: {
        type: String
      }
    },
    data(){
      return {
        show: true,
        defaultConfig: {},
        ignoredFields: ['content']
      };
    },
    computed: {
      isEditor(){
        return this.mode === 'edit';
      }
    },
    methods: {
      applyDefaultConfig() {
        bbn.fn.iterate(bbn.fn.extend({}, this.defaultConfig, this.cfg || {}), (a, n) => {
          if (this.source[n] === undefined) {
            //this.$set(this.source, n, a);
            this.source[n] = a;
          } else {
            //this.source[n] = a;
          }
        });
      },
      setSource(prop, val) {
        if (!val) {
          delete this.source[prop];
        }
        else {
          this.$set(this.source, prop, val);
        }
      },
    },
    watch: {
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
    },
    created() {
      if (this.source.type
        && !!this.source._elementor
      ) {
        this.applyDefaultConfig();
      }

      const config = {};
      bbn.fn.iterate(this.source, (a, n) => {
        if (!this.ignoredFields.includes(n)) {
          config[n] = a;
        }
      });
      this.$emit('configinit', config);
    },
    mounted() {
      this.ready = true;
    }
  };
  bbn.cp.addUrlAsPrefix(
    'appui-note-cms-block-',
    'components/',
    [bbn.cp.mixins.basic, bbn.cp.mixins['appui-note-cms-block']]
  );

  return {
    /**
     * @mixin bbn.cp.mixins.basic
     */
    mixins: [bbn.cp.mixins.basic, bbn.cp.mixins.resizer],
    props: {
      special: {
        type: String
      },
      cfg: {
        type: Object,
        default() {
          return {};
        }
      },
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
        initialSource: bbn.fn.clone(this.source),
        currentClass: 'bbn-w-100'
      };
    },
    computed: {
      ignoredFields() {
        return this.getRef('component')?.ignoreFields;
      },
      isSelected() {
        return this.selected === true;
      },
      currentComponent(){
        if (this.type === "container") {
          return "appui-note-cms-container";
        }
        return "appui-note-cms-block-" + this.type;
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
        bbn.fn.iterate(this.initialSource, (v, i)=>{
          this.source[i] = v;
          if (this.editable) {
            this.edit = false;
          }
        })
      },
      configInit(config) {
        this.$emit('configinit', config);
      }
    },
    mounted(){
      this.ready = true;
    },
    watch: {
      currentComponent(v) {
        this.ready = false;
        setTimeout(() => {
          this.ready = true;
        }, 100)
      }
    }
  };
})();
