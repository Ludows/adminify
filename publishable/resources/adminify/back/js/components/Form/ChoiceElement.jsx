import React, {useMemo, useEffect, useRef, useState} from 'react';
import Form from 'react-bootstrap/Form';
import { Portal } from 'react-portal';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';
import BaseForm from '@/back/js/components/BaseForm';

export default function ChoiceElement(props) {

  const field = useMemo(() => props.field, []);
  const register = useMemo(() => props.register, [props]);
  const choices = useMemo(() => field.choices, [props]);
  const choicesKeys = useMemo(() => Object.keys(choices), [choices]);
  const choiceRootRef = useRef({});
  const choiceRef = useRef({});


  const [show, setShow] = useState(false);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  useEffect(() => {
    choiceRef.current = choiceRootRef.current.querySelector('[type="'+ field.type +'"]');
    let instanceChoice = new Choices(choiceRef.current, field.select2options ? field.select2options : {});
    
    console.log('ChoiceElement.jsx onMounted', props);

    return () => {
      instanceChoice.destroy();
    }
  }, [])

  const handleModal = () => {
    handleShow();
  }

  return <>
    <div ref={choiceRootRef} {...field.sibling_attr} id={field.sibling}>
      <div {...field.wrapper}>
          {field.label_show &&
            <Form.Label {...field.label_attr} htmlFor={field.name}>
              {field.label}
              {field.withCreate &&
                <Button onClick={handleModal}>+</Button>
              }
            </Form.Label>
          }
          <Form.Select
            id={field.name}
            type={field.type}
            // ref={choiceRef}
            defaultValue={field.value ? field.value : ''}
            {...field.attr}
            {...register(field.name)}
          >
          
          {choicesKeys.length > 0 && choicesKeys.map((key) => <option value={key}>{choices[key]}</option> )}
              
          </Form.Select>
          {field.help_block.text &&
            <Form.Text {...field.help_block.attr} as={field.help_block.tag} muted>
              {field.help_block.text}
            </Form.Text>
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
                        <BaseForm form={field.modalForm}/>
                    </Modal.Body>
                </Modal>
            </Portal>
    }
  </>  
}