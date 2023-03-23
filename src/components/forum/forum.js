(() => {
	return {
		props: {
			data: {
        type: [Object, Function],
        default(){
          return {};
        }
      },
			filterable: {
        type: Boolean,
        default: false
      },
			pinnable: {
        type: Boolean,
        default: true
      },
			filters: {
				type: Object,
				default(){
					return {
						logic: 'AND',
						conditions: []
					};
				}
			},
			limit: {
        type: Number,
        default: 25
      },
			map: {
        type: Function
      },
			pageable: {
        type: Boolean,
        default: true
      },
      source: {
				type: [Array, String],
				default(){
					return [];
				}
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
			edit: {
				type: [Function, Boolean],
        default: false
			},
			remove: {
				type: [Function, Boolean],
        default: false
			},
			reply: {
				type: [Function, Boolean],
        default: false
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
      }
		},
		data(){
			return {
			  currentUser: appui.app.user.id,
				currentData: [],
				currentLimit: this.limit,
				currentFilters: bbn.fn.extend({}, this.filters),
				originalData: null,
				start: 0,
        total: 0,
				limits: [10, 25, 50, 100, 250, 500],
				isLoading: false,
        isAjax: typeof(this.source) === 'string',
				mediaFileType: appui.options.media_types.file.id,
        mediaLinkType: appui.options.media_types.link.id
			}
		},
		computed: {
			numPages(){
        return Math.ceil(this.total/this.currentLimit);
      },
			currentPage: {
        get(){
          return Math.ceil((this.start+1)/this.currentLimit);
        },
        set(val){
          this.start = val > 1 ? (val-1) * this.currentLimit : 0;
          this.updateData();
        }
      },
      toolbarButtons(){
        let r = [],
            ar = [];
        if ( this.toolbar ){
          //ar = $.isFunction(this.toolbar) ?
          ar = typeof(this.toolbar) === 'function' ?
            this.toolbar() : (
              Array.isArray(this.toolbar) ? this.toolbar.slice() : []
            );
          if ( Array.isArray(ar) ){
            bbn.fn.each(ar, (a, i) => {
              let o = bbn.fn.extend({}, a);
              if ( o.action ){
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
		  shorten: bbn.fn.shorten,
      _execCommand(button, data){
        if ( button.action ){
          //if ( $.isFunction(button.action) ){
          if ( typeof(button.action) === "function" ){
            return button.action(data);
          }
          else if ( typeof(button.action) === 'string' ){
            switch ( button.action ){
              case 'insert':
                return this.insert(data);
              case 'edit':
                return this.edit(data);
              case 'delete':
                return this.remove(data);
              case 'reply':
                return this.reply(data);
            }
          }
        }
        return false;
      },
      _map(data){
        //return this.map ? $.map(data, this.map) : data;
        return this.map ? bbn.fn.map(data, this.map) : data;
      },
      sdate(d){
        //return dayjs(d).format('DD/MM/YY')
        return bbn.fn.fdate(d, true);
      },
      ndate(d){
        return dayjs(d).format('DD/MM/YYYY');
      },
      ndatetime(d){
        return dayjs(d).format('DD/MM/YYYY HH:mm');
      },
      fdate(d){
        //return dayjs(d).format('DD/MM/YY HH:mm:ss');
        return bbn.fn.fdatetime(d, true);
      },
      hour(d){
        return dayjs(d).format('HH:mm')
      },
      hasEditUsers(users){
		    if ( users ){
          let u = users.split(',');
          if ( u.length > 1 ){
            return true;
          }
        }
        return false;
      },
      usersNames(creator, users, number){
        let ret = appui.app.getUserName(creator.toLowerCase()) || bbn._('Unknown'),
            u;
        if ( users ){
          u = users.split(',');
          if ( number ){
            return u.length;
          }
          if ( u.length > 1 ){
            u.forEach((v) => {
              if ( v !== creator ){
                ret += ', ' + appui.app.getUserName(v.toLowerCase()) || bbn._('Unknown');
              }
            });
          }
        }
        return number ? 0 : ret;
      },
			updateData(withoutOriginal){
        if ( this.isAjax && !this.isLoading ){
          this.isLoading = true;
          this.$nextTick(() => {
            let data = {
              limit: this.currentLimit,
              start: this.start,
              data: this.data ? ( typeof(this.data) === "function" ? this.data() : this.data) : {}
            };
            if ( this.filterable ){
              data.filters = this.currentFilters;
            }
            this.post(this.source, data, result => {
              this.isLoading = false;
              if (
                !result ||
                result.error ||
                ((result.success !== undefined) && !result.success)
              ){
                appui.alert(result && result.error ? result.error : bbn._("Error while updating the data"));
              }
              else {
                this.currentData = this._map(result.data || []);
                if ( this.editable ){
                  this.originalData = JSON.parse(JSON.stringify(this.currentData));
                }
                this.total = result.total || result.data.length || 0;
              }
            });
          });
        }
        else if ( Array.isArray(this.source) ){
          this.currentData = this._map(this.source);
          if ( this.isBatch && !withoutOriginal ){
            this.originalData = JSON.parse(JSON.stringify(this.currentData));
          }
          this.total = this.currentData.length;
        }
      },
      downloadMedia(id){
        if ( id && this.downloadUrl ){
          this.postOut(this.downloadUrl + id);
        }
      },
    },
    watch: {
      currentFilters: {
        deep: true,
        handler(){
          this.$nextTick(() => {
            this.updateData();
          });
        }
      },
      filters: {
        deep: true,
        handler(){
          this.$nextTick(() => {
            this.updateData();
          });
        }
      }
    },
		mounted(){
			this.$nextTick(() => {
        this.updateData();
      });
      this.ready = true;
		}
	}
})();
