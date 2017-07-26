<script>
    import injection from '../helpers/injection';

    export default {
        beforeRouteEnter(to, from, next) {
            injection.loading.start();
            injection.http.post(`${window.slideApi}/slide/group/get`, {
                group_id: to.query.id,
            }).then(() => {
                next(vm => {
                    vm.parent.id = to.query.id;
                    injection.loading.finish();
                    injection.sidebar.active('setting');
                });
            });
        },
        data() {
            return {
                action: `${window.api}/mall/admin/upload`,
                form: {
                    color: '',
                    link: '',
                    picture1: '',
                    picture2: '',
                    picture3: '',
                    picture4: '',
                    title: '',
                },
                parent: {
                    id: '',
                },
            };
        },
        methods: {
            goBack() {
                const self = this;
                self.$router.go(-1);
            },
            removeSlide1() {
                this.form.picture1 = '';
            },
            removeSlide2() {
                this.form.picture2 = '';
            },
            removeSlide3() {
                this.form.picture3 = '';
            },
            removeSlide4() {
                this.form.picture4 = '';
            },
            submitAddGroup() {
                const self = this;
                self.loading = true;
                self.$refs.groupAdd.validate(valid => {
                    if (valid) {
                        window.console.log(valid);
                    } else {
                        self.loading = false;
                        self.$notice.error({
                            title: '请正确填写设置信息！',
                        });
                    }
                });
            },
            uploadBefore() {
                injection.loading.start();
            },
//            uploadError(error, data) {
//                const self = this;
//                injection.loading.error();
//                if (typeof data.message === 'object') {
//                    for (const p in data.message) {
//                        self.$notice.error({
//                            title: data.message[p],
//                        });
//                    }
//                } else {
//                    self.$notice.error({
//                        title: data.message,
//                    });
//                }
//            },
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
                    title: data.message,
                });
                self.form.picture1 = data.data.path;
            },
        },
    };
</script>
<template>
    <div class="setting-wrap">
        <div class="slide-group-edit">
            <div class="edit-link-title">
                <i-button type="text" @click.native="goBack">
                    <icon type="chevron-left"></icon>
                </i-button>
                <span>轮播图插件-编辑图片内容</span>
            </div>
            <card :bordered="false">
                <div class="prompt-box">
                    <p>关于</p>
                    <p>每编辑一张图片需要点击保存，所有相关设置完成，使用底部的"更新板块内容"前台展示页面才会变化</p>
                </div>
                <i-form ref="form" :model="form" :rules="ruleValidate" :label-width="200">
                    <row>
                        <i-col span="14">
                            <form-item label="上传图片" prop="picture">
                                <div class="upload-picture-box">
                                    <div class="image-preview" v-if="form.picture1">
                                        <img :src="form.picture1">
                                        <icon type="ios-trash-outline" @click.native="removeSlide1"></icon>
                                        <div class="clearfix">
                                            <upload class="local-upload"
                                                    :action="action"
                                                    :before-upload="uploadBefore"
                                                    :format="['jpg','jpeg','png']"
                                                    :headers="{
                                                        Authorization: `Bearer ${$store.state.token.access_token}`
                                                    }"
                                                    :max-size="2048"
                                                    :on-error="uploadError"
                                                    :on-format-error="uploadFormatError"
                                                    :on-success="uploadSuccess"
                                                    ref="upload"
                                                    :show-upload-list="false">
                                                <div class="clearfix upload-picture">
                                                    <span>本地上传</span>
                                                </div>
                                            </upload>
                                            <upload class="picture-gallery-upload"
                                                    :action="action"
                                                    :before-upload="uploadBefore"
                                                    :format="['jpg','jpeg','png']"
                                                    :headers="{
                                                        Authorization: `Bearer ${$store.state.token.access_token}`
                                                    }"
                                                    :max-size="2048"
                                                    :on-error="uploadError"
                                                    :on-format-error="uploadFormatError"
                                                    :on-success="uploadSuccess"
                                                    ref="upload"
                                                    :show-upload-list="false">
                                                <div class="clearfix upload-picture">
                                                    <span>图片库上传</span>
                                                </div>
                                            </upload>
                                        </div>
                                    </div>
                                    <upload class="local-upload"
                                            :action="action"
                                            :before-upload="uploadBefore"
                                            :format="['jpg','jpeg','png']"
                                            :headers="{
                                                Authorization: `Bearer ${$store.state.token.access_token}`
                                            }"
                                            :max-size="2048"
                                            :on-error="uploadError"
                                            :on-format-error="uploadFormatError"
                                            :on-success="uploadSuccess"
                                            ref="upload"
                                            :show-upload-list="false"
                                            v-if="form.picture1 === '' || form.picture1 === null">
                                        <div class="clearfix upload-picture">
                                            <span>本地上传</span>
                                        </div>
                                    </upload>
                                    <upload class="picture-gallery-upload"
                                            :action="action"
                                            :before-upload="uploadBefore"
                                            :format="['jpg','jpeg','png']"
                                            :headers="{
                                                Authorization: `Bearer ${$store.state.token.access_token}`
                                            }"
                                            :max-size="2048"
                                            :on-error="uploadError"
                                            :on-format-error="uploadFormatError"
                                            :on-success="uploadSuccess"
                                            ref="upload"
                                            :show-upload-list="false"
                                            v-if="form.picture1 === '' || form.picture1 === null">
                                        <div class="clearfix upload-picture">
                                            <span>图片库上传</span>
                                        </div>
                                    </upload>
                                </div>
                            </form-item>
                        </i-col>
                    </row>
                    <h5>
                        图片详情设置
                        <span>提示：每编辑完成一组详情后需要点击保存</span>
                    </h5>
                    <row>
                        <i-col span="14">
                            <form-item label="图片标题">
                                <i-input v-model="form.title"></i-input>
                                <p class="tip">图片标题文字将作为图片Alt形式显示</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="图片跳转链接">
                                <i-input v-model="form.link"></i-input>
                                <p class="tip">输入图片要跳转的URL地址，正确格式应以http://开头，点击后将以"_blank"形式另打开页面</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item label="图片背景颜色">
                                <i-input v-model="form.color"></i-input>
                                <p class="tip">为确保现实效果美观，可设置轮播图整体背景填充色用于弥补图片在不同分辨率下显示区域
                                    超出图片时的问题，可根据图片的基础底色作为参照进行颜色设置</p>
                            </form-item>
                        </i-col>
                    </row>
                    <row>
                        <i-col span="14">
                            <form-item>
                                <i-button :loading="loading" type="primary"
                                          @click.native="submit">
                                    <span v-if="!loading">确认提交</span>
                                    <span v-else>正在提交…</span>
                                </i-button>
                                <i-button type="ghost">更新板块内容</i-button>
                            </form-item>
                        </i-col>
                    </row>
                </i-form>
            </card>
        </div>
    </div>
</template>