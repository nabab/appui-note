// Javascript Document

(() => {
  if (!appui.mixins) {
    appui.mixins = {};
  }
  let borderStyle = [
    {text: bbn._("hidden"), value: "hidden"},
    {text: bbn._("dotted"), value: "dotted"},
    {text: bbn._("dashed"), value: "dashed"},
    {text: bbn._("solid"), value: "solid"},
    {text: bbn._("double"), value: "double"},
    {text: bbn._("groove"), value: "groove"},
    {text: bbn._("ridge"), value: "ridge"}
  ];

  appui.mixins['appui-note-cms-reader'] =
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
          borderStyle:  borderStyle,
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
        currentStyle(){
          let res = {};
          bbn.fn.iterate(this.source.style || {}, (a, n) => {
            res[bbn.fn.camelize(n)] = a;
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
        decodeURIComponent(st){
          //the regular expression to match the new line
          /*let reg = /\r?\n|\r/g;
                  if(st.match(reg)){
                    st = st.replace(reg, '');
                  }*/
          //var st = bbn.fn.nl2br(st);
          return decodeURIComponent(this.escape(st));
        },
        escape(st){
          return escape(st)
        },
        /** calculates the height of the images in gallery basing on source.columns */
        setColor(a){
          this.source.style.color = a;
          this.$parent.edit = false
          //this.$forceUpdate()
        },
      }
    };

  appui.mixins['appui-note-cms-editor'] =
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
          borderStyle: borderStyle,
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
        carouselSource(){
          if (this.source.source && (this.source.type === 'carousel')){
            let res = [];
            var i,j,temparray, chunk = 3;
            for (i=0,j=this.source.source.length; i<j; i+=chunk) {
              temparray = this.source.source.slice(i,i+chunk);
              res.push(temparray);
              // do whatever
            }
            return res;
          }
        },
        mobile(){
          if ( bbn.env.width <= 640 ){
            this.$parent.isMobile = true;
            return true;
          }
          return false
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
        currentStyle(){
          let res = {};
          bbn.fn.iterate(this.source.style || {}, (a, n) => {
            res[bbn.fn.camelize(n)] = a;
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
        decodeURIComponent(st){
          //the regular expression to match the new line
          /*let reg = /\r?\n|\r/g;
                  if(st.match(reg)){
                    st = st.replace(reg, '');
                  }*/
          //var st = bbn.fn.nl2br(st);
          return decodeURIComponent(this.escape(st));
        },
        escape(st){
          return escape(st)
        },
        /** calculates the height of the images in gallery basing on source.columns */
        setColor(a){
          this.source.style.color = a;
          this.$parent.edit = false
          //this.$forceUpdate()
        },
        /** @todo Seriously these arguments names??  */
        imageSuccess(a, b, c, d){
          if (c.success && c.image.src.length ){
            if ( this.source.type === 'gallery' ){
              c.image.src = c.image.name;
              c.image.alt = '';
              setTimeout(() => {
                this.show = false;
                //this.source.content.push(c.image);//
                this.makeSquareImg();  
              }, 200);
            }
            else{
              this.source.content = c.image.name; 
            }
            appui.success(bbn._('Image correctly uploaded'))
          }
          else{
            appui.error(bbn._('An error occurred while uploading the image'))
          }

        }
      },
      beforeMount(){
        if ( bbn.fn.isEmpty(this.source.style) ){
          this.source.style = {}
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
        selected: false,
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
      onClick(e){
        if (this.selectable) {
          this.selected = true;
        }

        this.$emit('click', e);
      },
    	onSelectListener(e) {
        bbn.fn.log('onSelectListener', e);
        if (this.selected && (e.detail !== this.bbnUid)) {
          this.selected = false;
        }
      },
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
      if ( bbn.fn.isEmpty(this.source.style) ){
        bbn.fn.warning(this.source.type)
        this.source.style = {};
      }
      if ( bbn.fn.isEmpty(this.source.style) || !this.source.style.color ){
        this.source.style.color = '';
      }
      if ( !this.source.align ){
        this.source.align = 'left'
      }
      if ( bbn.fn.isEmpty(this.source.style) || !this.source.style.width ){
        this.source.width = '100%'
      }
      //if alignment is already defined as style property
      if ( this.source.style && this.source.style.align ){
        this.source.align = this.source.style.align;
      }

      bbn.fn.log("I AM THE BLOCK! ", this.source);
      this.initialSource = bbn.fn.extend({}, this.source);
      this.ready = true;
    },
    created(){
      if (this.selectable) {
        document.addEventListener('selectAppuiNoteCmsBlock', this.onSelectListener)
      }
    },
    beforeDestroy() {
      if (this.selectable) {
        document.removeEventListener('selectAppuiNoteCmsBlock', this.onSelectListener);
      }
    },
    watch: {
      selected(v){
        if (v) {
					const ev = new CustomEvent('selectAppuiNoteCmsBlock', {detail: this.bbnUid});
          document.dispatchEvent(ev);
        }
      },
      changed(){
        bbn.fn.log("changed")
      },
      type(){
        bbn.fn.log("type")
      },
      edit(val){
        /*
        //if adding a new block
        bbn.fn.error('watch')
        if ( ( val === false ) && ( this.newBlock === true ) ){
          this.parent.source.lines.push(this.source)
          this.parent.lines.push({
            content: { 
              data:  '<div>[CONTENT]</div>'
            },
            type: ''
          });
          appui.success(bbn._('New block ' + this.source.type + ' added!'))
          this.newBlock = false;
        }
        //this._setEvents()
        */
      }
    }
  };
})();