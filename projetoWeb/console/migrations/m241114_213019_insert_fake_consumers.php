<?php

use yii\db\Migration;

/**
 * Class m241114_213019_insert_fake_consumers
 */
class m241114_213019_insert_fake_consumers extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Inserindo dados na tabela `user`
        $this->batchInsert('{{%user}}',
            [
                'id',
                'username',
                'auth_key',
                'password_hash',
                'password_reset_token',
                'email',
                'status',
                'created_at',
                'updated_at',
                'verification_token'
            ],
            [
                [
                    2,
                    'joaosilva',
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('senha_segura'),
                    Yii::$app->security->generateRandomString() . '_' . time(),
                    'joao.silva@example.com',
                    9,
                    time(),
                    time(),
                    Yii::$app->security->generateRandomString() . '_' . time()
                ],
                [
                    3,
                    'mariasantos',
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('senha_segura'),
                    Yii::$app->security->generateRandomString() . '_' . time(),
                    'maria.santos@example.com',
                    9,
                    time(),
                    time(),
                    Yii::$app->security->generateRandomString() . '_' . time()
                ],
                [
                    4,
                    'carlosoliveira',
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('senha_segura'),
                    Yii::$app->security->generateRandomString() . '_' . time(),
                    'carlos.oliveira@example.com',
                    9,
                    time(),
                    time(),
                    Yii::$app->security->generateRandomString() . '_' . time()
                ],
                [
                    5,
                    'anacosta',
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('senha_segura'),
                    Yii::$app->security->generateRandomString() . '_' . time(),
                    'ana.costa@example.com',
                    9,
                    time(),
                    time(),
                    Yii::$app->security->generateRandomString() . '_' . time()
                ],
                [
                    6,
                    'ruipereira',
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('senha_segura'),
                    Yii::$app->security->generateRandomString() . '_' . time(),
                    'rui.pereira@example.com',
                    9,
                    time(),
                    time(),
                    Yii::$app->security->generateRandomString() . '_' . time()
                ],
                [
                    7,
                    'claralopes',
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('senha_segura'),
                    Yii::$app->security->generateRandomString() . '_' . time(),
                    'clara.lopes@example.com',
                    9,
                    time(),
                    time(),
                    Yii::$app->security->generateRandomString() . '_' . time()
                ],
                [
                    8,
                    'miguelrocha',
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('senha_segura'),
                    Yii::$app->security->generateRandomString() . '_' . time(),
                    'miguel.rocha@example.com',
                    9,
                    time(),
                    time(),
                    Yii::$app->security->generateRandomString() . '_' . time()
                ],
                [
                    9,
                    'sofiaalmeida',
                    Yii::$app->security->generateRandomString(),
                    Yii::$app->security->generatePasswordHash('senha_segura'),
                    Yii::$app->security->generateRandomString() . '_' . time(),
                    'sofia.almeida@example.com',
                    9,
                    time(),
                    time(),
                    Yii::$app->security->generateRandomString() . '_' . time()
                ],
            ]
        );

        // Inserindo dados na tabela `consumers`
        $this->batchInsert('{{%consumers}}',
            [
                'user_id',
                'name',
                'apelido',
                'email',
                'password',
                'nif_consumer',
                'telefone',
                'celular',
                'address',
                'codigo_postal',
                'cidade',
                'pais'
            ],
            [
                [2, 'João Silva', 'J. Silva', 'joao.silva@example.com', '$2y$13$3/oeGzzUwd/mFSUEy4cBceHAYJ1iHRFb7JQ7QZsGZ8.qTwdNN8K9y', '123456789', '212345678', '919876543', 'Rua das Flores, 123', '1000-001', 'Lisboa', 'Portugal'],
                [3, 'Maria Santos', 'M. Santos', 'maria.santos@example.com', '$2y$13$7XE9grNml2dAf5tRkOg9QOHlgJ65Jj/SKsyRWhVRlkLlkVdIv/RAy', '234567890', '223456789', '929876543', 'Avenida Central, 456', '2000-002', 'Porto', 'Portugal'],
                [4, 'Carlos Oliveira', 'C. Oliveira', 'carlos.oliveira@example.com', '$2y$13$d5AUbzyqYltj68Pa.SDHl.e7CFq5OvgxThE5Fkq/OxwPE04GZhMbK', '345678901', '234567890', '939876543', 'Travessa do Mar, 789', '3000-003', 'Coimbra', 'Portugal'],
                [5, 'Ana Costa', 'A. Costa', 'ana.costa@example.com', '$2y$13$aLGeRfD1OuYwJ5O7QxSsq.FV9iE3zM.DM.SFfPZk8gx3Y3.yZrzVC', '456789012', '245678901', '949876543', 'Rua do Sol, 10', '4000-004', 'Faro', 'Portugal'],
                [6, 'Rui Pereira', 'R. Pereira', 'rui.pereira@example.com', '$2y$13$D62CGA6HLpFQ8DBlXY.GLeVc9fIbGvT9JlGRgZRNPw9yyplLNiQyy', '567890123', '256789012', '959876543', 'Praça Nova, 11', '5000-005', 'Braga', 'Portugal'],
                [7, 'Clara Lopes', 'C. Lopes', 'clara.lopes@example.com', '$2y$13$J1M4IZRvF3Z61J8q2REJj.p72PlqqCRTP7RVMBdoen/erI0ROm3vK', '678901234', '267890123', '969876543', 'Beco das Palmeiras, 12', '6000-006', 'Aveiro', 'Portugal'],
                [8, 'Miguel Rocha', 'M. Rocha', 'miguel.rocha@example.com', '$2y$13$qfzDK2ftw7Wh5/EMbv7bk.4fpP7mQn6AO17EkN6oOSli9Iay6Hk9a', '789012345', '278901234', '979876543', 'Avenida das Águas, 13', '7000-007', 'Évora', 'Portugal'],
                [9, 'Sofia Almeida', 'S. Almeida', 'sofia.almeida@example.com', '$2y$13$XI0zFXfhA4Q8WCrVgKTxzOrwi/C1k4npRVFNfjMa7dyAvl96x.uDi', '890123456', '289012345', '989876543', 'Rua da Fonte, 14', '8000-008', 'Leiria', 'Portugal'],
            ]
        );
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Deletando dados da tabela `consumers`
        $this->delete('{{%consumers}}', ['user_id' => [2, 3, 4, 5, 6, 7, 8, 9]]);

        // Deletando dados da tabela `user`
        $this->delete('{{%user}}', ['id' => [ 2, 3, 4, 5, 6, 7, 8, 9]]);
    }
}