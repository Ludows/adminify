import React, { forwardRef, useEffect, useMemo, useState, useContext } from 'react';
import Form from 'react-bootstrap/Form';
import useErrors from '../../hooks/useErrors';
import useMediaPicker from '@/back/js/hooks/useMediaPicker';


const MediaElement = forwardRef((props, ref) => {
  const field = useMemo(() => props.field, []);
  const register = useMemo(() => props.register, [props]);
  const [selection, setSelection] = useState([]);
  const [isInvalid, error] = useErrors(field.name);
  const {show, hide, onSave} = useMediaPicker();

  const saveCallback = (datas) => {
    // console.log('saved callback',datas, field);
    if(datas.config.uuid === field.sibling) {
      setSelection(datas.selection);
    }
  }

  onSave(saveCallback);

  useEffect(() => {
    console.log('MediaElement.jsx onMounted', props);
  }, [])

  const pluckSelection = () => {
    let ret = '';
    if(selection.length > 0) {
      let ids = selection.map((media, index, array) => { return media.id });
      ret = ids.join(',');
    }
    return ret;
  }

  const showMediaPicker = (e) => {
    e.preventDefault();
    show({
      config: field.media_element_options,
      selection : []
    });
  }

  const handleModal = (media) => {
    // console.log('from a')
    show({
      config :field.media_element_options,
      selection : selection
    });
  }

  const handleRemoveItemFromSelection = (e, media) => {
    e.preventDefault();
    e.stopPropagation();
    setSelection((sel) => sel.filter((mediaItem, index, array) => { return mediaItem.id != media.id }))
    // removeSelection(media);
  }

  return <>
    <div ref={ref} {...field.sibling_attr} id={field.sibling}>
      <div {...field.wrapper}>
          {field.label_show &&
            <Form.Label {...field.label_attr} htmlFor={field.name}>
              {field.label}
            </Form.Label>
          }
          <div className='row'>
          {selection.length > 0 && 
            selection.map((media, index, array) => {
              return <a key={index} href='#' onClick={(e) => { handleModal(media); }} className="col-12 mb-3 shadow-sm col-lg-3 position-relative">
                      <img className='img-fluid' src={media.path} />
                      <i onClick={(e) => { handleRemoveItemFromSelection(e, media)}}>
                        remove item
                      </i>
                    </a>
            })
          }
          </div>

          {selection.length == 0 && 
            <button onClick={showMediaPicker} {...field.media_element_options.btn.attr}>{field.media_element_options.btn.label}</button>
          }
          
          <Form.Control type="hidden" isInvalid={isInvalid} {...field.attr}
            {...register(field.name)} value={pluckSelection()} />

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
  </>  
})

export default MediaElement;