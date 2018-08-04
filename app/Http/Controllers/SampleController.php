<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Users;

class SampleController extends Controller
{
    public function __construct()
    {
        // ����Ń��O�C���F�ؒ��̐l�̂ݓ����悤�ɂ��Ă���B
        $this->middleware('auth');
    }
    
    // ���f���A�N�V�����i���\�b�h�j
    public function model()
    {
      // �쐬�������f���̃C���X�^���X��
      $md = new Users();
      
      // �f�[�^�擾
      $data = $md->getData();

      // �r���[��Ԃ�
      return view('sample.model', ['data' => $data]);
    }
    
    // �p�����[�^�t���A�N�V����
    public function type($type=nul) //�^�C�v�p�����[�^�������ꍇ�ɂ��Ή�����ׂɁA�����l��null���w�肵�Ă���
    {
      // �쐬�������f���̃C���X�^���X��
      $md = new Users();
      
      // �f�[�^�擾
      $data = $md->getDataByParam($type);

      // �r���[��Ԃ� 
      return view('hasparam', ['data' => $data]);
    }
}