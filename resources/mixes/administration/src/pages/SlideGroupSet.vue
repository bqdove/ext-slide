<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.api}/slide/picture/list`, {
                group_id: to.query.id,
            }).then(response => {
                const data = response.data.data;
                next(vm => {
                    if (data.length > 0) {
                        vm.form = data[0];
                        if (data[0] === undefined) {
                            vm.form.path = '';
                        } else if (data[1] === undefined) {
                            vm.form.path2 = '';
                        } else if (data[2] === undefined) {
                            vm.form.path3 = '';
                        } else if (data[3] === undefined) {
                            vm.form.path4 = '';
                        }
                        if (data[0] !== undefined) {
                            vm.form.path = data[0].path;
                        }
                        if (data[1] !== undefined) {
                            vm.form.path2 = data[1].path;
                        }
                        if (data[2] !== undefined) {
                            vm.form.path3 = data[2].path;
                        }
                        if (data[3] !== undefined) {
                            vm.form.path4 = data[3].path;
                        }
                    }
                    vm.parent.id = to.query.id;
                    vm.parent.name = to.query.name;
                    injection.loading.finish();
                    injection.sidebar.active('setting');
                });
            });
        },
        data() {
            return {
                action: `${window.api}/slide/picture/upload?group_id=${this.$route.query.id}`,
                form: {
                    pictureList: [
                        {
                            path: '',
                            sort: '',
                            link: '',
                            title: '',
                            check: false,
                        },
                    ],
                },
                loading: false,
                paramCount: '',
                parent: {
                    id: '',
                    name: '',
                },
                rules: {
                    path: [
                        {
                            message: '上传图片不能为空',
                            required: true,
                            trigger: 'blur',
                        },
                    ],
                },
            };
        },
        methods: {
            addSlideGroup() {
                this.form.pictureList.push({
                    path: '',
                    sort: '',
                    link: '',
                    title: '',
                    check: false,
                });
            },
            removeSlideGroup(index) {
                this.form.pictureList.splice(index, 1);
            },
            getDetailMessage(param) {
                const self = this;
                self.paramCount = param;
                let count = '';
                if (param === 1) {
                    count = self.form.path;
                } else if (param === 2) {
                    count = self.form.path2;
                } else if (param === 3) {
                    count = self.form.path3;
                } else if (param === 4) {
                    count = self.form.path4;
                }
                injection.loading.start();
                self.$http.post(`${window.api}/slide/picture/get`, {
                    path: count,
                }).then(response => {
                    self.form = response.data.data;
                    injection.loading.finish();
                    injection.sidebar.active('setting');
                });
            },
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
            removeSlide(item) {
                const self = this;
                self.$http.post(`${window.api}/slide/picture/delete`, {
                    path: item.path,
                }).then(() => {
                    self.$notice.open({
                        title: '删除图片信息成功！',
                    });
                    item.path = '';
                    self.$loading.start();
                    self.$notice.open({
                        title: '正在刷新数据...',
                    });
                }).catch(() => {
                    self.$notice.error({
                        title: '删除图片信息错误！',
                    });
                });
            },
            submit() {
                const self = this;
                let count = '';
                self.loading = true;
                injection.loading.start();
                if (self.paramCount === 1) {
                    count = self.form.path;
                }
                if (self.paramCount === 2) {
                    count = self.form.path2;
                }
                if (self.paramCount === 3) {
                    count = self.form.path3;
                }
                if (self.paramCount === 4) {
                    count = self.form.path4;
                }
                const params = {
                    path: count,
                    title: self.form.title,
                    link: self.form.link,
                    background: self.defaultProps.hex,
                };
                self.$refs.form.validate(valid => {
                    if (valid) {
                        self.$http.post(`${window.api}/slide/picture/set`, params).then(response => {
                            if (response.data.code === 200) {
                                self.$notice.open({
                                    title: '设置图片信息成功！',
                                });
                            }
                        }).catch(() => {}).finally(() => {
                            self.loading = false;
                        });
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
            uploadExceeded(file) {
                const self = this;
                if (file.size > 4096) {
                    self.$notice.error({
                        title: '该文件大小超出限制,请重新选择',
                    });
                }
            },
            uploadBefore() {
                injection.loading.start();
            },
            uploadFormatError(file) {
                this.$notice.warning({
                    title: '文件格式不正确',
                    desc: `文件 ${file.name} 格式不正确`,
                });
            },
            uploadSuccess(data) {
                const self = this;
                injection.loading.finish();
                self.$notice.open({
                    title: data.message[0],
                });
                const i = Number(data.data.u_index);
                self.form.pictureList.forEach((item, index) => {
                    if (i === index) {
                        item.path = data.data.path;
                    }
                });
            },
        },
    };
</script>
<template>
    <div class="setting-wrap">
        <div class="slide-group-set">
            <div class="edit-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>设置 "{{ parent.name }}" 组图</span>
            </div>
            <card :bordered="false">
                <i-form ref="form" :model="form" :rules="rules" :label-width="200">
                    <div class="form-slide-group" v-for="(item, index) in form.pictureList">
                        <row>
                            <i-col span="8">
                                <div class="upload-picture-box">
                                    <!--<div class="image-preview" v-if="item.path" @click="getDetailMessage(1)">-->
                                    <div class="image-preview" v-if="item.path">
                                        <img :src="item.path">
                                        <icon type="ios-trash-outline" @click.native="removeSlide(item)"></icon>
                                    </div>
                                </div>
                                <div class="btn-group">
                                    <upload class="local-upload"
                                            :action="action"
                                            :before-upload="uploadBefore"
                                            :format="['jpg','jpeg','png']"
                                            :headers="{
                                                Authorization: `Bearer ${$store.state.token.access_token}`
                                            }"
                                            :data="{
                                                u_index: index,
                                            }"
                                            :max-size="4096"
                                            :on-exceeded-size="uploadExceeded"
                                            :on-error="uploadError"
                                            :on-format-error="uploadFormatError"
                                            :on-success="uploadSuccess"
                                            ref="upload"
                                            :show-upload-list="false">
                                        <div class="clearfix upload-picture">
                                            <span>本地上传</span>
                                        </div>
                                    </upload>
                                    <div class="picture-gallery-upload ivu-upload">
                                        <div class="clearfix upload-picture">
                                            <span>图片库上传</span>
                                        </div>
                                    </div>
                                </div>
                            </i-col>
                            <i-col span="12">
                                <row>
                                    <i-col>
                                        <form-item label="图片标题" prop="title">
                                            <i-input v-model="item.title"></i-input>
                                            <p class="tip">图片标题文字将作为图片Alt形式显示</p>
                                        </form-item>
                                    </i-col>
                                </row>
                                <row>
                                    <i-col>
                                        <form-item label="图片跳转链接" prop="link">
                                            <i-input v-model="item.link"></i-input>
                                            <p class="tip">输入图片要跳转的URL地址，正确格式应以http://或https://开头</p>
                                            <checkbox v-model="item.check">通过新标签页打开</checkbox>
                                        </form-item>
                                    </i-col>
                                </row>
                                <row>
                                    <i-col>
                                        <form-item label="排序" prop="sort">
                                            <i-input v-model="item.sort"></i-input>
                                            <p class="tip">排序按照数字从小到大排列，输入后使用回车键更新排序</p>
                                        </form-item>
                                    </i-col>
                                </row>
                            </i-col>
                            <i-col span="4">
                                <span v-if="index !== 0" @click="removeSlideGroup(index)">
                                    <icon type="ios-trash-outline"></icon>
                                </span>
                            </i-col>
                        </row>
                    </div>
                    <div class="add-group-btn">
                        <span @click="addSlideGroup">
                            <icon type="android-add"></icon>
                        </span>
                    </div>
                </i-form>
            </card>
            <div class="submit-btn">
                <i-button :loading="loading" type="primary"
                          @click.native="submit">
                    <span v-if="!loading">确认提交</span>
                    <span v-else>正在提交…</span>
                </i-button>
            </div>
        </div>
    </div>
</template>