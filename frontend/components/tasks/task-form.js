import { Formik } from 'formik';
import { useContext } from 'react';
import { AppContext } from '../../context/app.context';
import { createTask, updateTask } from '../../services/tasks.service';
import { sleep } from '../../utils/common';
import { ErrorText } from '../common/error-text';
import { useRouter } from 'next/router'

export const TaskForm = ({ task }) => {

  const { setNotification } = useContext(AppContext);
  const router = useRouter()

  const buttonText = !!task ? "Update Task" : "Create Task";

  const submitForm = async ({title, description}) => {
    const res = !!task
      ? await updateTask({id: task.id, title, description})
      : await createTask({title, description})

    return res;
  }

  return (
    <Formik
      initialValues={{ title: task?.title, description: task?.description }}

      onSubmit={async (values, { setSubmitting, setErrors }) => {
        await sleep(700);

        try {
          const res = await submitForm(values);

          if (res.status !== 201 && res.status !== 200) return;

          const message = res.status === 201 ? 'Successfully created new task' : 'Successfully updated the task';

          setNotification({
            type: 'success',
            shown: true,
            message
          });

          await sleep(300);

          router.push("/");

        } catch (error) {
          const errors = error.response.data?.errors;

          const title_error = errors?.title?.[0];
          const description_error = errors?.description?.[0];

          setErrors({title: title_error, description: description_error })

          setSubmitting(false)
        }
      }}
    >
      {({
        values,
        errors,
        touched,
        handleChange,
        handleBlur,
        handleSubmit,
        isSubmitting,
      }) => (
        <form className='flex flex-col space-y-2' onSubmit={handleSubmit}>
          <div className='flex flex-col space-y-1'>
            <label className='text-blue-600 font-semibold text-lg'>Title</label>
            <input
              type="text"
              name='title'
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.title}
              className='border border-gray-200 p-2 rounded-md outline-none'
            />
            {errors?.title && touched?.title && <ErrorText>{errors.title}</ErrorText>}
          </div>

          <div className='flex flex-col space-y-1'>
            <label className='text-blue-600 font-semibold text-lg'>Description</label>
            <textarea
              name="description"
              cols="30"
              rows="10"
              onChange={handleChange}
              onBlur={handleBlur}
              value={values.description}
              className='border border-gray-200 p-2 rounded-md outline-none'
            ></textarea>
            {errors?.description && touched?.description && <ErrorText>{errors?.description}</ErrorText>}
          </div>

          <button type="submit" disabled={isSubmitting} className='bg-blue-600 hover:bg-blue-700 text-blue-100 py-2 rounded-md'>
            {!isSubmitting ? buttonText : "Submitting..."}
          </button>
        </form>
      )}
    </Formik>
  )
}
