<?php if(isset($disciplinas) && $disciplinas->count() != 0): ?>

    <div class="row col-md-8 col-md-offset-2" style="margin-top: 2em; margin-bottom: -1em">
        <div id="titulo" class="titulo" data-qtd_disciplina="<?php echo e($disciplinas->count()); ?>" data-total="<?php echo e($total_aulas); ?>" data-turno="<?php echo e($turma->turno); ?>"> 
            <h4 class="text-center text-uppercase">
                <strong> HORÁRIO 
                    <?php if($turma->turno == 'M' || $turma->turno == 'D'): ?> DA MANHÃ:
                    <?php elseif($turma->turno == 'T'): ?> DA TARDE:
                    <?php elseif($turma->turno == 'N'): ?> DA NOITE:
                    <?php endif; ?>
                </strong>
            </h4>
        </div>
    </div>

    <div class="table-responsive col-md-12">
        <table class="table table-striped bunitu">
            <thead class="btn-primary">
                <tr class="row text-uppercase">
                    <th class="text-center">AULA</th>
                    <th class="text-center">SEGUNDA</th>
                    <th class="text-center">TERÇA</th>
                    <th class="text-center">QUARTA</th>
                    <th class="text-center">QUINTA</th>
                    <th class="text-center">SEXTA</th>
                </tr>
            </thead>

            <?php if($turma->turno == 'M' || $turma->turno == 'D'): ?>
                <?php for($aula = 1; $aula <= 4; $aula++ ): ?>
                    <tr class="row text-uppercase">
                        <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula); ?>ª AULA </td>
                        <?php for($dia = 1; $dia <= 5; $dia++): ?>
                            <td class="text-center form-group">
                                <select class="selectpicker form-control select-center" id="horario<?php echo e($aula); ?><?php echo e($dia); ?>" name="horario[<?php echo e($aula); ?>][<?php echo e($dia); ?>]">
                                    <option data-tokens="ketchup mustard" data-nome="AULA VAGA" data-ch="0" value="0"> AULA VAGA </option>
                                    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('horario.<?php echo e($aula); ?>.<?php echo e($dia); ?>') == $disc->id): ?>
                                            <option data-tokens="ketchup mustard" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->id); ?>" selected> <?php echo e($disc->sigla); ?> </option>
                                        <?php endif; ?>
                                    <option data-tokens="ketchup mustard" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->id); ?>"><?php echo e($disc->sigla); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            <?php elseif($turma->turno == 'T'): ?>
                <?php for($aula = 5; $aula <= 8; $aula++ ): ?>
                    <tr class="row text-uppercase">
                        <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula - 4); ?>ª AULA </td>
                        <?php for($dia = 1; $dia <= 5; $dia++): ?>
                            <td class="text-center">
                                <select class="selectpicker form-control select-center" id="horario<?php echo e($aula); ?><?php echo e($dia); ?>" name="horario[<?php echo e($aula); ?>][<?php echo e($dia); ?>]">
                                    <option data-tokens="ketchup mustard" data-nome="AULA VAGA" data-ch="0" value="0"> AULA VAGA </option>
                                    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('horario.<?php echo e($aula); ?>.<?php echo e($dia); ?>') == $disc->id): ?>
                                            <option data-tokens="ketchup mustard" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->id); ?>" selected> <?php echo e($disc->sigla); ?> </option>
                                        <?php endif; ?>
                                    <option data-tokens="ketchup mustard" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->id); ?>"><?php echo e($disc->sigla); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            <?php elseif($turma->turno == 'N'): ?>
                <?php for($aula = 9; $aula <= 12; $aula++ ): ?>
                    <tr class="row text-uppercase">
                        <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula - 8); ?>ª AULA </td>
                        <?php for($dia = 1; $dia <= 5; $dia++): ?>
                            <td class="text-center">
                                <select class="selectpicker form-control select-center" id="horario<?php echo e($aula); ?><?php echo e($dia); ?>" name="horario[<?php echo e($aula); ?>][<?php echo e($dia); ?>]">
                                    <option data-tokens="ketchup mustard" data-nome="AULA VAGA" data-ch="0" value="0"> AULA VAGA </option>
                                    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('horario.<?php echo e($aula); ?>.<?php echo e($dia); ?>') == $disc->id): ?>
                                            <option data-tokens="ketchup mustard" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->id); ?>" selected> <?php echo e($disc->sigla); ?> </option>
                                        <?php endif; ?>
                                    <option data-tokens="ketchup mustard" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->id); ?>"><?php echo e($disc->sigla); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            <?php endif; ?>
        </table>
    </div>

    <div class="row col-md-8 col-md-offset-2" style="margin-top: -2em">
       <span class="help-block text-center" ">
           <strong id="table-1"></strong>
       </span>
    </div>

    <?php if($turma->turno == 'D'): ?>
        <div class="row col-md-8 col-md-offset-2" style="margin-top: 2em;margin-bottom: -1em">
            <div class="titulo"> 
                <h4 class="text-center text-uppercase">
                    <strong> HORÁRIO DA TARDE: </strong>
                </h4>
            </div>
        </div>

        <div class="table-responsive col-md-12">
            <table class="table table-striped bunitu">
                <thead class="btn-primary">
                    <tr class="row text-uppercase">
                        <th class="text-center">AULA</th>
                        <th class="text-center">SEGUNDA</th>
                        <th class="text-center">TERÇA</th>
                        <th class="text-center">QUARTA</th>
                        <th class="text-center">QUINTA</th>
                        <th class="text-center">SEXTA</th>
                    </tr>
                </thead>

                <?php for($aula = 5; $aula <= 8; $aula++ ): ?>
                    <tr class="row text-uppercase">
                        <td class="text-center" style="vertical-align: middle;"> <?php echo e($aula - 4); ?>ª AULA </td>
                        <?php for($dia = 1; $dia <= 5; $dia++): ?>
                            <td class="text-center">
                                <select class="selectpicker form-control select-center" id="horario<?php echo e($aula); ?><?php echo e($dia); ?>" name="horario[<?php echo e($aula); ?>][<?php echo e($dia); ?>]">
                                    <option data-tokens="ketchup mustard" data-nome="AULA VAGA" data-ch="0" value="0"> AULA VAGA </option>
                                    <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(old('horario.<?php echo e($aula); ?>.<?php echo e($dia); ?>') == $disc->id): ?>
                                            <option data-tokens="ketchup mustard" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->id); ?>" selected> <?php echo e($disc->sigla); ?> </option>
                                        <?php endif; ?>
                                    <option data-tokens="ketchup mustard" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->id); ?>"><?php echo e($disc->sigla); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>

        <div class="row col-md-8 col-md-offset-2" style="margin-top: -2em">
           <span class="help-block text-center" ">
               <strong id="table-2"></strong>
           </span>
        </div>
    <?php endif; ?>

    <div class="row col-md-12">
        <div class="row col-md-8 col-md-offset-2" style="margin-bottom: 2em;margin-top: 2em">
            <div id="tituloDisciplina" class="titulo" data-disciplinas="<?php echo e($disciplinas->count()); ?>"> 
                <h4 class="text-center text-uppercase">
                    <strong> Disciplinas: </strong>
                </h4>
            </div>
        </div>
      
        <?php $__currentLoopData = $disciplinas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $disc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <div class="row col-md-12">
                <div class="form-group col-md-6 disciplina<?php echo e($disc->id); ?>">
                    <div class="col-md-12">
                        <input id="disciplina<?php echo e($loop->iteration); ?>" name="disciplina[<?php echo e($disc->id); ?>]" maxlength="160" data-nome="<?php echo e($disc->nome); ?>" data-ch="<?php echo e($disc->aula_semanal); ?>" value="<?php echo e($disc->sigla); ?> - <?php echo e($disc->nome); ?>" data-id="<?php echo e($disc->id); ?>" class="form-control input-md" type="text" readonly>
                    
                       <span class="help-block text-center">
                           <strong id="disciplina<?php echo e($disc->id); ?><?php echo e($disc->id); ?>"></strong>
                       </span>
                    </div>

                </div>

                <div class="form-group col-md-6 professor<?php echo e($disc->id); ?>">
                    <label class="col-md-3 control-label" for="professor">Professor:</label>
                    <div class="col-md-9">

                        <select class="selectpicker form-control text-uppercase" id="professor<?php echo e($disc->id); ?>" name="professor[<?php echo e($disc->id); ?>]">
                            <option data-tokens="ketchup mustard" value="0" selected> -- SELECIONE O PROFESSOR --</option>
                             <?php $__currentLoopData = $professores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prof): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option data-tokens="ketchup mustard" value="<?php echo e($prof->id); ?>"><?php echo e($prof->username); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        </select>

                       <span class="help-block text-center" ">
                           <strong id="professor<?php echo e($disc->id); ?><?php echo e($disc->id); ?>"></strong>
                       </span>
                    </div>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="form-group col-md-12" ></div>
    <div class="form-group col-md-12" ></div>

    <div class="row col-md-7 col-md-offset-3">
        <div class="form-group col-md-5">
            <button type="submit" class="btn btn-block btn-lg btn-success">
                Cadastrar
            </button>     
        </div>

        <div class="form-group col-md-2" ></div>

        <div class="form-group col-md-5">
            <a href="<?php echo e(route('turma.show')); ?>" class="btn btn-block btn-lg btn-danger">
                Cancelar
            </a>   
        </div>
    </div>
    
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

<?php else: ?>
    <div class="alert alert-warning btn-lg col-md-8 col-md-offset-2 danger text-center">
        <span class="glyphicon glyphicon-warning-sign"></span> Não há disciplinas cadastradas associadas a essa turma. <br>Informe ao administrador do sistema!!
    </div>

    <div class="row col-md-2 col-md-offset-5">
        <div class="form-group text-center text-uppercase">
            <a href="<?php echo e(route('turma.show')); ?>" class="btn btn-block btn-lg btn-primary">
                <span class="glyphicon glyphicon-arrow-left"></span> Voltar
            </a>   
        </div>
    </div>
<?php endif; ?>