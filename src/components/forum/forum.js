(() => {
	return {
    mixins: [
      bbn.vue.basicComponent,
      bbn.vue.listComponent
    ],
		props: {
			pinnable: {
        type: Boolean,
        default: true
      },
			imageDom: {
				type: String
			},
			downloadUrl: {
				type: String
			},
			toolbar: {
        type: [String, Array, Function, Object]
      },
			editEnabled: {
				type: Boolean,
        default: true
			},
			removeEnabled: {
				type: Boolean,
        default: true
			},
			replyEnabled: {
				type: Boolean,
        default: true
      },
      topicButtons: {
        type: Array,
        default(){
          return [];
        }
      },
      replyButtons: {
        type: Array,
        default(){
          return [];
        }
      },
      canLock: {
        type: Boolean,
        default: true
      },
      types: {
        type: Array,
        default(){
          return [];
        }
      }
		},
		data(){
			return {
			  currentUser: appui.app.user.id,
				mediaFileType: appui.options.media_types.file.id,
        mediaLinkType: appui.options.media_types.link.id
			}
		},
		computed: {
			toolbarButtons(){
        let r = [];
        if ( this.toolbar ){
          let ar = bbn.fn.isFunction(this.toolbar) ?
            this.toolbar() :
            (bbn.fn.isArray(this.toolbar) ? this.toolbar.slice() : []);
          if (bbn.fn.isArray(ar)) {
            bbn.fn.each(ar, a => {
              let o = bbn.fn.clone(a);
              if (o.action) {
                o.action = () => {
                  this._execCommand(a);
                }
              }
              r.push(o);
            });
          }
        }
        return r;
      }
		},
		methods: {
      _execCommand(button, data){
        if (button.action) {
          if (bbn.fn.isFunction(button.action)) {
            return button.action(data);
          }
          else if (bbn.fn.isString(button.action)) {
            switch (button.action) {
              case 'insert':
                return this.$emit('insert', data);
              case 'edit':
                return this.$emit('edit', data);
              case 'delete':
                return this.$emit('remove', data);
              case 'reply':
                return this.$emit('reply', data);
            }
          }
        }
        return false;
      },
			downloadMedia(id){
        if (!!id && this.downloadUrl) {
          this.postOut(this.downloadUrl + id);
        }
      }
    },
    mounted(){
			this.ready = true;
		}
	}
})();
