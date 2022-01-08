/**
 *
 * @param {int} taskPage - The current task page
 * @param {function} setTaskPage - To set the task page
 * @param {int} lastPage - The last page of the paginator
 * @returns
 */
export const usePagination = (taskPage, setTaskPage, lastPage) => {

  /**
   * Function to handle click of the next button in pagination
   * @returns
   */
  const onClickPrev = () => {
    if (taskPage <= 1) return;

    const updatedTaskPage = taskPage - 1;

    setTaskPage(updatedTaskPage);
  }

  /**
   * Function to handle click of the prev button in pagination
   * @returns
   */
  const onClickNext = () => {
    if (taskPage >= lastPage) return;

    const updatedTaskPage = taskPage + 1;

    setTaskPage(updatedTaskPage);
  }

  return {onClickPrev, onClickNext}
}
