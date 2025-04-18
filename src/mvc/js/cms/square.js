// Javascript Document

(() => {
  return {
    data(){
      let lines = [];
      if (this.source.lines.length) {
        bbn.fn.each(this.source.lines, a => {
          lines.push(a);
        })
      }
			lines.push({
        content: { 
          data:  '<div>[CONTENT]</div>'
        },
        type: ''
      });
		  return {
        focused: false,
        lines: lines,
        currentBlockType: '',
        blockChoice: [
          {
            text: 'HTML Content',
            icon: 'nf nf-seti-text',
            code: 'html',
            action:() => {
              this.currentBlockType = 'html'
            }
          }, {
            text: 'Image gallery',
           // icon: 'nf nf-md-image_multiple',
            icon: 'nf nf-md-view_grid',
            code: 'gallery',
            action:() => {
              this.currentBlockType = 'gallery'
            }
          },{
            text: 'Image',
            icon: 'nf nf-md-image',
            code: 'image',
            action:() => {
              this.currentBlockType = 'image'
            }
          },{
            text: 'Video',
            icon: 'nf nf-fa-video_camera',
            code: 'video',
            action:() => {
              this.currentBlockType = 'video'
            }
          },{
            text: 'Line',
            icon: 'nf nf-md-border_horizontal',
            code: 'line',
            action:() => {
              this.currentBlockType = 'line'
            }
          },
          {
            text: 'Button',
            icon: 'nf nf-md-cursor_pointer',
            code: 'button',
            action:() => {
              this.currentBlockType = 'button'
            }
          }   
        ]
      };
    },
    
    methods: {
      open(){
        bbn.fn.happy(open)
      },
      render(){
        return '[CONTENT]'
      },
      add(){
        //make the difference beetwen focused === source.lines.length and other focused to add the block at the exact position
        if ( this.focused === this.source.lines.length ){
          this.lines[this.focused].type = this.currentBlockType
          this.$nextTick(()=>{
            //the watch on the prop edit in bbn-block will add a new empty block in this.lines when newBlock is true
            this.$refs['block'][this.focused].edit = true;
            this.$refs['block'][this.focused].newBlock = true;
          })
        }
      }
    },
    components: {
      control: {
        props: [ 'source', 'index'],
        template: `
					<div class="control">
            <bbn-context :source="source"
												 @open="parent.focused = index"
            >
              <bbn-button :notext="true"
                          icon="nf nf-fa-plus"
								          :title="_('Add a new block to this row')"
							>
              </bbn-button>
            </bbn-context>
            <bbn-button :notext="true"
                        bbn-if="$parent.$parent.lines[index] && $parent.$parent.lines[index]['type']"
                        icon="nf nf-fa-edit"
												@click="editBlock"
												:title="_('Edit blocks in this row')"
						>
            </bbn-button>
					</div>
				`,
        computed: {
          parent(){
            return this.closest('bbn-container').getComponent();
          }
        },
        methods: {
          editBlock(){
            this.parent.focused = this.index;
            bbn.fn.map(this.parent.$refs['block'], (a)=>{
              return a.edit = false;
            })
            this.parent.$refs['block'][this.index].ready = false;
            this.parent.$refs['block'][this.index].edit = true;
            this.parent.$refs['block'][this.index].ready = true;
          },
        }, 
      }
    },
    watch: {
      /* When the bbn-context of types changes value */
      currentBlockType(val){
        bbn.fn.error('error here')
        if ( ( this.focused > -1 ) && ( this.focused !== this.source.lines.length ) ){
      		//for the bbn-block template to be defined based on the type of block there's a bbn-if on the prop ready on the html of the component bbn-block
          this.$refs['block'][this.focused].edit = false;
          this.$refs['block'][this.focused].ready = false;
          this.$refs['block'][this.focused].source.type = val;
          this.$nextTick( ()=>{
            this.$refs['block'][this.focused].ready = true;
          })    
        }
        else {
          this.add()
        }
      }
    }
  };
})();