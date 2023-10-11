import React, {useMemo, useEffect, useRef, useState, forwardRef, createRef} from 'react';
import Form from 'react-bootstrap/Form';
import { Portal } from 'react-portal';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import BaseForm from '../../components/BaseForm';
import useErrors from '../../hooks/useErrors';
import useHelpers from '../../hooks/useHelpers';

const ChoiceElement = forwardRef((props, ref) => {
  if(!ref) {
    ref = createRef({});
  }

  const field = useMemo(() => props.field, [props]);
  const register = useMemo(() => props.register, [props]);
  const choices = useMemo(() => field.choices, [props]);
  const choicesKeys = useMemo(() => Object.keys(choices), [choices]);
  const choiceRef = useRef({});
  let instanceChoice = useRef({});
  const { createCustomRenderer, formatValue } = useHelpers();

  const [isInvalid, error] = useErrors(field.name);

  const [show, setShow] = useState(false);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  let customRender = createCustomRenderer(null, {...props}, ref);

  if(customRender) {
    return customRender;
  }

  useEffect(() => {
    choiceRef.current = ref.current.querySelector('[type="'+ field.type +'"]');
    
    instanceChoice.current = new Choices(choiceRef.current, field.select2options ? field.select2options : {});

    // console.log('ChoiceElement.jsx onMounted', props, field); 

    return () => {
      instanceChoice.current.destroy();
    }
  }, [])

  if(!field) {
    return null;
  }

  const handleSubmitResults = (datas) => {
    if(field.modalForm.uuid == datas.form.uuid) {
      handleClose();
      let {current:instance} = instanceChoice;

      instance.setValue([
        { value: datas.data.entity.id, label: datas.data.entity.title },
      ])
    }
  }
  

  const handleModal = () => {
    handleShow();
  }

  let valueFormater = formatValue(field.value);

  return <>
    <div ref={ref} {...field.sibling_attr} id={field.sibling}>
      <div {...field.wrapper}>
          {field.label_show &&
            <Form.Label {...field.label_attr} htmlFor={field.name}>
              {field.label}
              {field.withCreate &&
                <Button variant='outline-primary' className='ms-3' onClick={handleModal}>
                  <i class="bi bi-plus-circle-fill"></i>
                </Button>
              }
            </Form.Label>
          }
          <Form.Select
            id={field.name}
            type={field.type}
            isInvalid={isInvalid}
            // ref={choiceRef}
            defaultValue={valueFormater}
            {...field.attr}
            {...register(field.name)}
          >
          
          {choicesKeys.length > 0 && choicesKeys.map((key, index) => <option key={index} value={key}>{choices[key]}</option> )}
              
          </Form.Select>
          {field.help_block.text &&
            <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
              {field.help_block.text}
            </Form.Text>
          }
          {error &&
            <Form.Control.Feedback type="invalid">
              {error}
            </Form.Control.Feedback>
          }
          
          
      </div>
    </div>

    {field.withCreate &&
            <Portal>
                <Modal centered="true" size="lg" show={show} onHide={handleClose}>
                    {/* <Modal.Header closeButton>
                        <Modal.Title>{getTranslation('admin.global_search')}</Modal.Title>
                    </Modal.Header> */}
                    <Modal.Body>
                        <BaseForm onSubmitResults={handleSubmitResults} useLoader={false} form={field.modalForm}/>
                    </Modal.Body>
                </Modal>
            </Portal>
    }
  </> 
})
export default ChoiceElement;